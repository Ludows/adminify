<?php

namespace Ludows\Adminify\Http\Middleware;

use Illuminate\Support\Facades\App;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use ReflectionClass;

class MultilangBasic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct() {
        $this->base_params = [];
    }
    public function getParam($key) {
        return $this->base_params[$key];
    }
    public function param($key, $value = null) {
        $this->base_params[$key] = $value;

        return $this;
    }
    public function getParams() {
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
    public function handleSettings() {
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
    public function handleMetas($parameters = []) {
        if(!empty($parameters['model'])) {
            $formated_metas = $parameters['model']->metas->pluck('value', 'key');
            $this->param('metas_keys', $formated_metas->toArray());
        }
    }
    public function handle(Request $request, Closure $next)
    {

        $config = config('site-settings');
        $supported_locales = $config['supported_locales'];
        $route = $request->route();
        $routeName = $request->route()->getName();
        $prefix = $route->getPrefix();
        $v = view();

        $themeManager = theme_manager();
        $themeConfigClass = $themeManager->config();

        $checkedKeys = [
            'update',
            'edit',
            'destroy'
        ];

        $currentLocale = App::currentLocale();
        $routeNameSpl = explode('.', $routeName);

        if(is_admin() && !empty($prefix)) {
            // dd('$prefix', $prefix);
            array_unshift($routeNameSpl , 'admin');

        }



        // making autoswitch back / front
        $singular = singular($routeNameSpl['1']);
        $model = \Route::current()->parameter($singular);
        if(!is_admin() && !in_array($routeName, ['image.transform', 'theme.assets'])) {
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

        if(!is_admin() && empty($request->segments())) {
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
        $theme = $themeManager->getTheme();

        $named = join('.',array_diff($routeNameSpl, ['index', 'edit', 'create']));
        // $bindedEditorKeys = array_keys($config['editor']['bind']);

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
            'isTemplate' => !empty($model) ? is_template($model) : false
            // "loadEditor" => false,
            // 'bindedEditorKeys' => $bindedEditorKeys
        ];

        if(is_admin() && $isContentModel && empty($theme)) {
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
            if(!empty($topbarPref)) {
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
        }

        // $fileToHandle($themeManager, $request, $this->getParams());

        $this->params($base_parameters);

        if(is_front() && !is_running_console()) {
            $this->handleSettings();
            $this->handleMetas($base_parameters);
        }



        if(!in_array($routeName, $themeManager->getIgnores()) && !is_running_console()) {
            $themeManager->setToConstructor($themeConfigClass, [
                'manager' => $themeManager,
                'request' => request(),
                'params' => $this->getParams(),
                'middleware' => $this,
            ])->fireConfig();
        }




        // if your want to had your required vars for your templates.
        if(method_exists($this, 'bootingInject')) {
             call_user_func_array(array($this, 'bootingInject'), [$request, $base_parameters]);
        }


        foreach ($this->getParams() as $key => $value) {
            # code...
            $v->share($key, $value);
            add_to_request($key, $value);
        }

        foreach ($checkedKeys as $checkedKey) {
            # code...
            if(in_array($checkedKey , $routeNameSpl )) {
                merge_to_request('isCrudPattern', true);
                break;
            }
        }

        $v->share('request', $request);

        if($config['multilang']) {

            $langParameter = $request->get('lang');
            // dd($request->get('lang'), $currentLocale);
            if($langParameter && $langParameter != $currentLocale) {
                //we update the value
                $v->share('currentLang', $langParameter);
                App::setLocale($langParameter);
                $currentLocale = $langParameter;
                merge_to_request('lang', $currentLocale);
            }

            if(!isset($request->lang) && !in_array('store' , $routeNameSpl )) {
                merge_to_request('lang', $currentLocale);
                $v->share('currentLang', $currentLocale);
                return redirect(route($routeName, ['lang' => $request->lang]));
            }
            else {
                return $next($request);
            }

        }
        else {
            return $next($request);
        }
    }
}
