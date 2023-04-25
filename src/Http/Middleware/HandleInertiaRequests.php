<?php

namespace Ludows\Adminify\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use ReflectionClass;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Link;
use Ludows\Adminify\Libs\AdminMenuService;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    // protected $rootView = 'theme::featuring.layouts.app';

    public $base_params;
    public $theme;

    public function __construct() {
        $this->base_params = [];
        $this->theme = theme();
    }

    public function getParam($key) {
        return $this->base_params[$key];
    }
    public function param($key, $value = null) {
        $this->base_params[$key] = $value;

        return $this;
    }
    public function getParams():array {
        return $this->base_params;
    }
    public function removeParam($key) {
        unset($this->base_params[$key]);
        return $this;
    }

    public function params($array) {
        if(!is_array($array)) {
            throw new Exception('You must provide an array of params for merging to the current request', $this->base_params);
        }

        foreach ($array as $key => $value) {
            # code...
            $this->param($key, $value);
        }
    }

    public function handleSettings(): void {
        $settings = settings();

        foreach ($settings as $key => $value) {
            # code...
            if($value->type == 'logo_id' && !empty($value->data)) {
                $this->param('logo', media((int) $value->data));
            }

            if($value->type == 'homepage' && !empty($value->data)) {
                $this->param('home_url', config('app.url') );
            }

            if(method_exists($this, 'handleCustomSetting')) {
                $this->handleCustomSetting($key, $value);
            }

            $this->param($value->type, $value->data);
        }
    }

    public function handleMetas($parameters = []):void {
        if(!empty($parameters['model'])) {
            $formated_metas = $parameters['model']->metas->pluck('value', 'key');
            $this->param('metas_keys', $formated_metas->toArray());
        }
    }

    public function rootView(Request $request)
    {
        return $this->handleInertia();
    }

    public function handleInertia(): string {
        $isFront = is_front();
        if(!is_installed()) {
            throw new Error('Adminify must be installed for Inertia');
        }

        $inertia_url = '';

        if($isFront) {
            $inertia_url = 'theme::'.$this->theme.'.layouts.app';
        }
        else {
            $inertia_url = 'adminify::layouts.app';
        }


        return $inertia_url;
    }

    public function handleMultilang($request, $config, $parameters):void {
        if($config['multilang']) {

            $langParameter = $request->get('lang');
            // dd($request->get('lang'), $currentLocale);
            if($langParameter && $langParameter != $parameters['currentLocale']) {
                //we update the value
                App::setLocale($langParameter);
                $parameters['currentLocale'] = $langParameter;
            }
        }
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), $this->prepareSharedDatas($request));
    }

    public function manageAdminMenu($request) {
        $user = user();
        $multilang = config('site-settings.multilang');
        $menu_config = get_site_key('adminMenu');
        $enables_features = get_site_key('enables_features');
        $lang = lang();

        $adminMenu = new AdminMenuService();

        $arrayDatas = array(
            'user' => $user,
            'multilang' => $multilang,
            'lang' => $lang,
            'features' => $enables_features
        );

        $adminMenu->resolve($arrayDatas);

        return $adminMenu->getItems();

    }

    public function prepareSharedDatas($request): array {

        $config = config('site-settings');
        $supported_locales = $config['supported_locales'];
        $route = $request->route();
        $routeName = $request->route()->getName();
        $prefix = $route->getPrefix();
        $isAdmin = is_admin();
        $adminMenu = null;


        $checkedKeys = [
            'update',
            'edit',
            'destroy'
        ];

        $currentLocale = App::currentLocale();
        $routeNameSpl = explode('.', $routeName);

        if($isAdmin && !empty($prefix)) {
            array_unshift($routeNameSpl , 'admin');
        }

        if($isAdmin) {
            $adminMenu = $this->manageAdminMenu($request);
        }

        // making autoswitch back / front
        $singular = singular($routeNameSpl['1']);
        $model = \Route::current()->parameter($singular);
        if(!$isAdmin && !is_auth_routes() && !in_array($routeName, ['image.transform', 'theme.assets', 'editor.preview', 'forms.validate'])) {
            // dd($routeName,adminify_get_class( \Str::studly( $routeNameSpl['1'] ), ['app:models', 'app:adminify:models'], false ));
            $theClass = adminify_get_class( \Str::studly( $routeNameSpl['1'] ), ['app:models', 'app:adminify:models'], false );
            $model = new $theClass();
            $model = $model->where('slug', str_replace('_', '-', $routeNameSpl['2']))->get()->first();
        }

        if(startsWith($routeName, 'savetraductions') && $config['multilang']) {

            $model = adminify_get_class($request->get('model'), ['app:models', 'app:adminify:models'], false);
            $model = new $model;
            $model = $model->find($request->get('id'));

        }

        if(!$isAdmin && empty($request->segments())) {
            $settings = cache('homepage');

            if($settings == null) {
                $settings = setting('homepage');
            }

            $model = adminify_get_class('Page', ['app:models', 'app:adminify:models'], false);

            $model = $model::find( is_array($settings) ? $settings['model_id'] : $settings );
        }

        if($routeName == 'globalsearch') {
            $searchpage = setting('searchpage');
            $model = adminify_get_class('Page', ['app:adminify:models', 'app:models'], true);

            $model = $model->find($searchpage);
        }

        // dd(adminify_autoload());
        // let's do the magic editor preview handling here model.
        if($routeName == 'editor.preview') {

            $isCreate = !empty($request->type) && empty($request->id);
            $isEdit = !empty($request->type) && !empty($request->id);

            // try to load the first one model
            $model = adminify_get_class(titled($request->type), ['app:adminify:models', 'app:models'], true);

            if(empty($model)) {
                // however we try to load model in singular
                $model = adminify_get_class(titled(singular($request->type)), ['app:adminify:models', 'app:models'], true);
            }

            // if you reedit a current model. We make sure that you bind the correct content.

            if($isEdit) {
                $model = $model->find($request->id);

                // now we can check if is homepage for correct handle controller response :)
                $isHome = is_homepage($model);
            }

            // if model is really empty. preview does not work properly. Throw Error.
            if(empty($model)) {
                throw new Error('Model with '.$request->type. 'cannot be found.');
            }

        }

        $isContentModel = !empty($model) ? is_content_type_model($model) : false;
        $theme = $this->theme;

        $named = join('.',array_diff($routeNameSpl, ['index', 'edit', 'create']));

        if(strpos($named, '.') != false) {
            $named = explode('.', $named);
            $named = $named[ count($named) - 1 ];
        }

        if(!empty($model)) {
            $reflection = new ReflectionClass($model);
            $type = $reflection->getShortName();
        }

        $base_parameters = [
            "siteConfig" => $config,
            "name" => $named,
            "isCrudPattern"=> false,
            "prefixUrl" => $prefix,
            "singleParam"=> count($routeNameSpl) > 2 ? Str::singular($routeNameSpl[ count($routeNameSpl) - 2 ])  : Str::singular($routeNameSpl[0]),
            "currentRouteSplitting" => $routeNameSpl,
            "routeParameters" => $request->route()->parameters(),
            "useMultilang" => (bool) $config['multilang'],
            "lang"=> $currentLocale,
            "currentLang" => $currentLocale,
            "langs" => $supported_locales,
            "currentRouteName" => $routeName,
            "isCreate" => strpos($routeName, '.create') != false ? true : false,
            "isEdit" => strpos($routeName, '.edit') != false ? true : false,
            "isUpdate" => strpos($routeName, '.update') != false ? true : false,
            "isDestroy" => strpos($routeName, '.destroy') != false ? true : false,
            "isContentModel" => $isContentModel,
            "isIndex" => strpos($routeName, '.index') != false ? true : false,
            "model" => $model,
            "type" => $type ?? null,
            "enabled_features" => config('site-settings.enables_features'),
            "form" => null,
            "user" => user(),
            "adminify_autoload" => adminify_autoload(),
            'isPreview' => $routeName == 'editor.preview',
            'adminMenu' => $adminMenu,
            'isTemplate' => !empty($model) ? is_template($model) : false
        ];

        if($isAdmin && $isContentModel && empty($theme)) {
            throw new \Exception("Theme must be set in administration", $theme);
        }

        if( $isContentModel || $base_parameters['isPreview']) {
            $posts = null;
            // si c'est la page de blog. Autoappend des posts.
            if(is_blogpage($model)) {
                $posts = new \App\Adminify\Models\Post();
                $posts = $posts->withStatus( status()::PUBLISHED_ID )->paginate( get_site_key('blog.paginate'), get_site_key('blog.columns'), get_site_key('blog.param') );
            }
            $topbarPref = get_user_preference('topbar');
            $topbarShow = false;

            // get the current theme
            if(empty($theme)) {
                throw new \Exception("Theme must be set in administration", $theme);
            }

            //dd($topbarPref);
            if(!empty($topbarPref) && !$base_parameters['isPreview']) {
                $topbarShow = (bool)$topbarPref;
            }
            // add specifics globals vars
            $base_parameters['isHome'] = is_homepage($model);
            $base_parameters['isSingle'] = is_single($model);
            $base_parameters['isBlogPage'] = is_blogpage($model);
            $base_parameters['isSearch'] = is_search($model);
            $base_parameters['isPage'] = $base_parameters['isSearch'] ? false : is_page($model);
            $base_parameters['posts'] = $posts;
            $base_parameters['topbarShow'] = $topbarShow;
            $base_parameters['theme'] = $theme;

            if($base_parameters['enabled_features']['pwa']) {
                $pwa = model('Pwa'); 
                $settings = model('Settings');
                
                $results = $settings->where('type', 'like', '%'.$pwa->getKeySetting('').'%' )->get();
                $results = $results->pluck('data', 'type')->toArray();
    
                $results['_settings_pwa_icons'] = json_decode($results['_settings_pwa_icons'], true); 
                $base_parameters['pwa'] = $results;
            }
        }

        if(method_exists($this, 'addParameters')) {
            $this->addParameters();
        }

        $this->handleMultilang($request, $config, $base_parameters);

        return $base_parameters;
    }
}
