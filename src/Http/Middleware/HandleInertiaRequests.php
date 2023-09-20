<?php

namespace Ludows\Adminify\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use ReflectionClass;
use Ludows\Adminify\Libs\AdminMenuService;
use Illuminate\Support\Facades\Route;

use Ludows\Adminify\Traits\SeoGenerator;

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
    public $preventables_paths;

    use SeoGenerator;

    public function __construct() {
        $this->base_params = [];
        $this->preventables_paths = ['image.transform', 'theme.assets', 'admin.editor.preview', 'forms.validate', 'manifest'];
    }

    public function getParam($key) {
        $check = !empty($this->base_params[$key]);
        return $check ? $this->base_params[$key] : null;
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
                call_user_func_array(array($this, 'handleCustomSetting'), [$key, $value]);
            }

            $this->param($value->type, $value->data);
        }
    }

    public function handleRevisions($parameters = []) {
        if( !empty($parameters['model']) && $parameters['isBack'] ) {
            $this->param('revisions', $parameters['model']->revisions);
        }
    } 

    public function handleBreadcrumb($currentRoute = '', $parameters = []) {
        $ret = [];
        $routeNameSpl = explode('.', $currentRoute);
        $savePatron = $routeNameSpl;

        if(is_admin()) {
            $ret = ['admin.home.dashboard'];
            array_pop($savePatron);
            $patron = join('.', $savePatron);
            // dd($savePatron, $routeNameSpl, $patron);

            if(Route::has($patron.'.index')) {
                $ret[] = $patron.'.index';
            }
    
            if(Route::has($patron.'.create') && $parameters['isCreate']) {
                $ret[] = $patron.'.create';
            }
    
            if(Route::has($patron.'.edit') && $parameters['isEdit']) {
                $ret[] = $patron.'.edit';
            }
        }
        else {
            if(method_exists($this, 'handleFrontBreadcrumb')) {
                call_user_func_array(array($this, 'handleFrontBreadcrumb'), []);
            }
        }
        
        $this->param('breadcrumb', $ret);
        return $ret;
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
        $isFront = is_front() && !is_auth_routes();
        $viewResolver = view();
        $frontViewExist = $viewResolver->exists('front::layouts.app');
        $backViewExist = $viewResolver->exists('back::layouts.app');
        $fallbackBackView = 'adminify::layouts.app';
        // ->exists('category.custom.'.$category->slug)
        if(!is_installed()) {
            throw new Error('Adminify must be installed for Inertia');
        }

        $inertia_url = '';
        if($isFront) {
            $inertia_url = 'front::layouts.app';
        }
        else {
            $inertia_url = $backViewExist ? 'back::layouts.app' : $fallbackBackView;
        }


        return $inertia_url;
    }

    public function handleMultilang($request, $config, $parameters):void {
        $inertia = inertia();
        if($config['multilang']) {

            $langParameter = $request->get('lang');
            // dd($request->get('lang'), $currentLocale);
            if($langParameter && $langParameter != $parameters['currentLocale']) {
                //we update the value
                App::setLocale($langParameter);
                $inertia->share('currentLocale', $langParameter);
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

    public function bindModel($config = [], Request $request):void {

        $route = $request->route();
        $routeName = $route->getName();
        $isAdmin = is_admin();
        $isMultilang = is_multilang();
        $isFront = is_front();
        $isAuthRoutes = is_auth_routes();
        $routeNameSpl = explode('.', $routeName);
        $model = null;

        $parameters = $route->parameters();

        

        if($isAdmin) {
            foreach ($routeNameSpl as $key => $partialRouteName) {
                # code...
                $singular = singular($partialRouteName);
                $model = $route->parameter( $singular );
                if(empty($model)) {
                    $model = $route->parameter( $partialRouteName );
                }
                if(!empty($model)) {
                    break;
                }
            }


            // $this->setParam('model',  )
            if(startsWith($routeName, 'savetraductions') && $isMultilang) {
                $model = model($request->get('model'), false);
                $model = new $model;
                $model = $model->find($request->get('id'));
            }
            if($routeName == 'admin.editor.preview') {
                $isEditInEditor = !empty($request->type) && !empty($request->id);

                // try to load the first one model
                $model = model(titled($request->type));

                if(empty($model)) {
                    // however we try to load model in singular
                    $model = model(titled(singular($request->type)));
                }

                // if you reedit a current model. We make sure that you bind the correct content.

                if($isEditInEditor) {
                    $model = $model->find($request->id);
                }
            }
        }

        if($isFront && !$isAuthRoutes && !in_array($routeName, $this->preventables_paths)) {
            // dd($routeNameSpl);
            $theClass = model( \Str::studly( $routeNameSpl['1'] ), false);
            if(empty($theClass)) {
                $theClass = model( \Str::studly( $routeNameSpl['0'] ), false);
            }
            $model = new $theClass();
            $model = $model->where('slug', str_replace('_', '-', $routeNameSpl['2']))->get()->first();
        }

        if($isFront) {
            if(empty($request->segments())) {
                $settings = cache('homepage');
    
                if($settings == null) {
                    $settings = setting('homepage');
                }
    
                $model = model('Page', false);
    
                $model = $model::find( is_array($settings) ? $settings['model_id'] : $settings );
            }
            if($routeName == 'globalsearch') {
                $searchpage = setting('searchpage');
                $model = model('Page', true);

                $model = $model->find($searchpage);
            }
        }

        $this->param('model', $model);

    }

    public function bindParameters($config = [], Request $request):void {

        $currentLocale = App::currentLocale();
        $model = $this->getParam('model');
        $route = $request->route();
        $routeName = $route->getName();
        $prefix = $route->getPrefix();
        $routeNameSpl = explode('.', $routeName);
        $supported_locales = $config['supported_locales'];
        $isEditorRoute = $routeName == 'admin.editor.preview';


        if($prefix == '/admin') {
            array_unshift($routeNameSpl, 'admin');
        }


        $isContentModel = !empty($model) ? is_content_type_model($model) : false;
        // $theme = $this->theme;

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
            "isFront" => is_front(),
            "isBack" => !is_front(),
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
            'isPreview' => $isEditorRoute,
            'isTemplate' => !empty($model) ? is_template($model) : false
        ];

        $this->params($base_parameters);

    }

    public function bindSeo() {
        $isFront = is_front();
        $isBack = is_admin();
        $isAuth = is_auth_routes();
        $route = request()->route();
        $routeName = $route->getName();
        $resolver = null;

        // $hasModel = !empty( $this->getParam('model') );
        if($isBack || $isAuth) {
            $resolver = [];
            $resolver['title'] = __('admin.seo.title'); // todo parameter for change page
            $resolver['description'] = __('admin.seo.description');
            $resolver['keywords'] = __('admin.seo.keywords');
            $resolver['robots'] = 'none';
            $resolver['type'] = 'page';
        }
        if($isFront) {
            $resolver = $this->getParam('model');
        }
        if(!in_array($routeName, $this->preventables_paths)) {
            $this->handleSeo($resolver);
            $seo = $this->grabSeo();
            $this->param('seo', $seo);
        }
        else {
            $this->param('seo', '\n');
        }
        // dd('seo', app('seotools.json-ld')->generate(true) );
    }

    public function bindFrontParameters($config = [], Request $request):void {

        $isContentModel = $this->getParam('isContentModel');
        $isPreview = $this->getParam('isPreview');
        $model = $this->getParam('model');

        $params = [];

         if( $isContentModel && is_front() || $isPreview) {
            $posts = null;
            // si c'est la page de blog. Autoappend des posts.
            if(is_blogpage($model)) {
                $hasModelForFetch = !empty(get_site_key('blog.model'));
                $posts = $hasModelForFetch ? get_site_key('blog.model') : new \App\Adminify\Models\Post();
                $posts = $posts->withStatus( status()::PUBLISHED_ID )->paginate( get_site_key('blog.paginate'), get_site_key('blog.columns'), get_site_key('blog.param') );
            }
            $topbarPref = get_user_preference('topbar');
            $topbarShow = false;

            // // get the current theme
            // if(empty($theme)) {
            //     throw new \Exception("Theme must be set in administration", $theme);
            // }

            //dd($topbarPref);
            if(!empty($topbarPref) && !$isPreview) {
                $topbarShow = (bool)$topbarPref;
            }
            // add specifics globals vars
            $params['isHome'] = is_homepage($model);
            $params['isSingle'] = is_single($model);
            $params['isBlogPage'] = is_blogpage($model);
            $params['isSearch'] = is_search($model);
            $params['isPage'] = $params['isSearch'] ? false : is_page($model);
            $params['posts'] = $posts;
            $params['topbarShow'] = $topbarShow;
            // $base_parameters['theme'] = $theme;

            if($config['enables_features']['pwa']) {
                $pwa = model('Pwa'); 
                $settings = model('Settings');
                
                $results = $settings->where('type', 'like', '%'.$pwa->getKeySetting('').'%' )->get();
                $results = $results->pluck('data', 'type')->toArray();
    
                $results['_settings_pwa_icons'] = json_decode($results['_settings_pwa_icons'], true); 
                $params['pwa'] = $results;
            }
        }

        $this->params($params);
    }

    // public function bindMetas( Request $request ):void {
    //     dd( $this->getParams(), inertia()->getShared() );
    // }

    public function prepareSharedDatas($request): array {

        $config = config('site-settings');
        $route = $request->route();
        $routeName = $request->route()->getName();
        $prefix = $route->getPrefix();
        $isAdmin = is_admin();
        $adminMenu = null;

        $routeNameSpl = explode('.', $routeName);

        if($isAdmin && !empty($prefix)) {
            array_unshift($routeNameSpl , 'admin');
        }

        $this->bindModel($config, $request);
 
        $this->bindParameters($config, $request);

        $base_parameters = $this->getParams();


        if($isAdmin) {
            $adminMenu = $this->manageAdminMenu($request);
        }

        // dd($adminMenu, is_front());

        $this->param('adminMenu', $adminMenu);

        $this->bindFrontParameters($config, $request);

        $this->bindSeo();

        // $this->bindMetas($request);

        $this->handleBreadcrumb($routeName, $base_parameters);
        $this->handleRevisions($base_parameters);
        


        if(method_exists($this, 'addParameters')) {
            call_user_func_array(array($this, 'addParameters'), [$this->getParams()]);
        }

        $this->handleMultilang($request, $config, $base_parameters);


        foreach ($this->getParams() as $key => $value) {
            # code...
            $base_parameters[$key] = $value;
        }


        return $base_parameters;
    }
}
