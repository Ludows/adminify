<?php
use Thunder\Shortcode\ShortcodeFacade;
use App\Adminify\Models\Translations as Traduction;
use App\Adminify\Models\Forms;
use App\Adminify\Models\Menu;
use App\Adminify\Models\Media;
use App\Adminify\Models\Settings;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use League\Glide\Urls\UrlBuilderFactory;
use Illuminate\Support\Facades\Storage;
use Ludows\Adminify\Libs\ThemeManager;
use Ludows\Adminify\Libs\HookManager;
use Illuminate\Support\Facades\Route;

if(! function_exists('is_closure') ) {
    function is_closure($t) {
        return $t instanceof \Closure;
    }
}

if(! function_exists('maybeEncodeData') ) {
    function maybeEncodeData($value) {
        if (is_object($value) || is_array($value)) {
            return json_encode($value, true);
        }
        return $value;
    }
}

if(! function_exists('maybeDecodeData') ) {
    function maybeDecodeData($value) {
        $object = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $object;
        }

        return $value;
    }
}

if(! function_exists('mailer') ) {
    function mailer() {
        return app()->make(Snowfire\Beautymail\Beautymail::class);
    }
}

if (! function_exists('adminify_autoload')) {
    function adminify_autoload() {
        return cache('adminify.autoload');
    }
}

if (! function_exists('uuid')) {
    function uuid($length = 10) {
        return Str::random($length);
    }
}

if(! function_exists('is_content_type_model')) {
    function is_content_type_model($model) {
        $r = new \ReflectionClass( $model );
        return $r->isSubclassOf( new \ReflectionClass( 'Ludows\Adminify\Models\ContentTypeModel' ) );
    }
}

if(! function_exists('is_template')) {
    function is_template($model) {
        $r = new \ReflectionClass( $model );
        return $r->isSubclassOf( new \ReflectionClass( 'Ludows\Adminify\Models\Templates' ) );
    }
}

if(! function_exists('is_adminify')) {
    function is_adminify() {
        return defined('IS_ADMINIFY') == true;
    }
}

if(!function_exists('locales')) {
    function locales() {
        return config('site-settings.supported_locales');
    }
}

if(! function_exists('is_auth_routes')) {
    function is_auth_routes() {
        $ret = false;
        $isRunning = is_running_console();
        if(!$isRunning) {
            $r = request();
            $inertia = inertia();
            $split_route = $inertia->getShared('currentRouteSplitting');

            if(empty($split_route)) {
                // fallback when currentRouteSplitting is not defined
                $routeName = $r->route()->getName();
                $split_route = explode('.', $routeName);
            }

            // currentRouteSplitting
            $ret = $split_route[0] === 'auth';
        }
        return $ret;
    }
}

if(! function_exists('is_running_console')) {
    function is_running_console() {
        return app()->runningInConsole();
    }
}

if(! function_exists('adminify_asset')) {
    function adminify_asset($path) {
        $isRunning = is_running_console();
        $basePathFromEnv = env('APP_URL');

        if($isRunning) {
            return $basePathFromEnv.$path;
        }
        else {
            return asset($path);
        }
    }
}

if (! function_exists('adminify_get_classes')) {
    function adminify_get_classes($array, $context, $loadClass) {
        $r = [];

        if(!isset($loadClass)) {
            $loadClass = false;
        }

        if(!isset($context)) {
            $context = null;
        }

        if(is_array($array)) {
            foreach ($array as $a) {
                # code...
                $the_class = adminify_get_class($a, $context,  $loadClass);
                if(!empty($the_class)) {
                    $r[] = $the_class;
                }
            }
        }
        return $r;
    }
}

if (! function_exists('adminify_get_classes_by_folder')) {
    function adminify_get_classes_by_folder($folder) {
        $r = null;
        $cache = adminify_autoload();

        if($cache != null && !empty($folder) && !empty($cache[$folder]) && is_array($cache[$folder])) {
            $r = $cache[$folder];
        }

        return $r;
    }
}

if (! function_exists('adminify_get_classes_by_folders')) {
    function adminify_get_classes_by_folders($array) {
        $r = [];
        foreach ($array as $a) {
            # code...
            $res = adminify_get_classes_by_folder($a);
            if(!empty($res)) {
                $r = array_merge($r, $res);
            }
        }
        return $r;
    }
}

if (! function_exists('look_file')) {
    function look_file($fullFilePath) {
        $f = app('File');
        $r = null;

        if($f::exists($fullFilePath)) {
            $r = [
                'status' => 'OK',
                'content' => $f::get($fullFilePath),
            ];
        }

        return $r;
    }
}

// if(! function_exists('add_asset')) {
//     function add_asset($collection = 'default', $mixed = null) {
//         return Assets::group($collection)->add($mixed);
//     }
// }

if (! function_exists('adminify_get_class')) {
    function adminify_get_class($name, $context, $loadClass) {

        if(!isset($loadClass)) {
            $loadClass = false;
        }

        $r = null;
        $cache = adminify_autoload();

        if(!empty($context) && is_string($context) && !empty($cache[$context])) {
            $cache = $cache[$context];
        }

        if(!empty($context) && is_array($context)) {
            $newcache = [];
            if(count($context) > 0) {
                foreach ($context as $cntxt) {
                    # code...
                    if(!empty($cache[$cntxt])) {
                        $newcache = array_merge($newcache, $cache[$cntxt]);
                    }
                }
            }
            $cache = $newcache;
        }

        $keys = array_keys($cache);

        foreach ($keys as $k) {
            # code...
            if($r != null) {
                break;
            }
            if(is_array($cache[$k]) && empty($context)) {

                $a = $cache[$k];
                $keyeds = array_keys($a);

                foreach ($keyeds as $keyed) {
                    # code...
                    if($keyed == $name) {
                        $r = $a[$keyed];
                        if($loadClass) {
                            $r = app($r);
                        }
                        break;
                    }
                }

            }

            if(is_string($cache[$k]) && !empty($context)) {
                $index_a = array_search($name, $keys);
                if($name == $keys[$index_a] && !empty($cache[$name])) {
                    $r = $cache[$name];
                    if($loadClass) {
                        $r = app($r);
                    }
                }
            }

        }


        return $r;
    }
}

if (! function_exists('singular')) {
    function singular($name = '') {
        return Str::singular($name);
    }
}

if(! function_exists('containsIn')) {
    function containsIn($string = '', $mixed = '') {
        return Str::contains($string, $mixed);
    }
}

if (! function_exists('slug')) {
    function slug($name = '') {
        return Str::slug($name);
    }
}

if (! function_exists('titled')) {
    function titled($name = '') {
        return Str::title($name);
    }
}

if (! function_exists('startsWith')) {
    function startsWith($string = '', $mixed = '') {
        return Str::startsWith($string, $mixed);
    }
}

if (! function_exists('endsWith')) {
    function endsWith($string = '', $mixed = '') {
        return Str::endsWith($string, $mixed);
    }
}

if (! function_exists('interfaces')) {
    function interfaces($name = '') {
        $interface = config('site-settings.interfaces.'.$name);
        return app($interface);
    }
}

if (! function_exists('plural')) {
    function plural($name = '') {
        return Str::plural($name);
    }
}

if (! function_exists('lowercase')) {
    function lowercase($name = '') {
        return Str::lower($name);
    }
}

if (! function_exists('uppercase')) {
    function uppercase($name = '') {
        return Str::upper($name);
    }
}

if(! function_exists('is_homepage') ) {
    function is_homepage($class) {
        // the relationship model
        $ret = false;
        $s = setting('homepage');
        if(!empty($s) && $class->id == $s && $class instanceof \App\Adminify\Models\Page) {
            $ret = true;
        }
        return $ret;
    }
}

if(! function_exists('is_blogpage') ) {
    function is_blogpage($class) {
        // the relationship model
        $ret = false;
        $s = setting('blogpage');
        if(!empty($s) && $class->id == $s && $class instanceof \App\Adminify\Models\Page) {
            $ret = true;
        }
        return $ret;
    }
}

if(! function_exists('is_single') ) {
    function is_single($class) {
        $ret = false;
        if($class instanceof \App\Adminify\Models\Post) {
            $ret = true;
        }
        return $ret;
    }
}

if(! function_exists('is_page') ) {
    function is_page($class) {
        // the relationship model
        $ret = false;
        $s = setting('blogpage');

        if(!empty($s) && $class->id != $s && $class instanceof \App\Adminify\Models\Page) {
            $ret = true;
        }
        else if(empty($s) && $class instanceof \App\Adminify\Models\Page) {
            $ret = true;
        }

        return $ret;
    }
}

if(! function_exists('is_search')) {
    function is_search($class) {
        // the relationship model
        $ret = false;
        $s = setting('searchpage');

        if(!empty($s) && $class->id == $s && $class instanceof \App\Adminify\Models\Page) {
            $ret = true;
        }

        return $ret;
    }
}

if(! function_exists('is_multilang') ) {
    function is_multilang() {
        // the relationship model
        $ret = false;
        $c = get_site_key('multilang');

        if(!empty($c)) {
            $ret = $c;
        }
        return (bool) $ret;
    }
}

if(! function_exists('model')) {
    function model($model_base_name, $loadClass = true) {
        $cls = adminify_get_class($model_base_name, ['app:adminify:models', 'app:models'], $loadClass);
        return $cls;
    }
}

if(! function_exists('is_trashable_model')  ) {
    function is_trashable_model($class) {
        // the relationship model
        $f = $class->getFillable();
        return in_array($class->status_key, $f);
    }
}

if(! function_exists('get_missing_langs')) {
    function get_missing_langs($model) {
        $request = inertia();
        $langs = [];
        if($request->getShared('useMultilang') && is_translatable_model($model)) {
            $langs = $model->getNeededTranslations();
        }
        return $langs;
    }
}

if(! function_exists('is_seo_model')) {
    function is_seo_model($class) {
        return method_exists($class,'seoWith');
    }
}

if(! function_exists('get_user_preferences')) {
    function get_user_preferences() {
        $u = user();
        return $u != null ? $u->preferences : null;
    }
}

if(! function_exists('get_user_preference')) {
    function get_user_preference($type) {
        $u = user();
        return $u != null ? $u->getPreference($type) : null;
    }
}

if(! function_exists('toolbar')) {
    function toolbar() {
        $t = new ToolBar();
        return $t->render();
    }
}

if(! function_exists('is_urlable_model')) {
    function is_urlable_model($class) {
        return method_exists($class,'url');
    }
}
if(! function_exists('array_equal')) {
    function array_equal($a, $b) {
        return (
            is_array($a)
            && is_array($b)
            && count($a) == count($b)
            && array_diff($a, $b) === array_diff($b, $a)
        );
    }
}

if(! function_exists('get_url')) {
    function get_url($class) {
        if(is_urlable_model($class)) {
            return $class->url;
        }
    }
}

if(! function_exists('get_urlpath')) {
    function get_urlpath($class) {
        if(is_urlable_model($class)) {
            return $class->urlpath;
        }
    }
}

if(! function_exists('user')) {
    function user() {
        $request = request();
        //multilang basic middleware appends automatic to the request the current user;
        if(empty($request->user)) {
            $userLoggued = auth()->user();

            if(empty($userLoggued)) {
                $roleModel = app('App\Adminify\Models\Role');
                $userLoggued = app('App\Adminify\Models\User')->find($roleModel::GUEST);
            }
        }
        else {
            $userLoggued = $request->user;
        }

        return $userLoggued;
    }
}

if(! function_exists('vendor_path')) {
    function vendor_path($path = '') {
        return base_path('vendor'.$path);
    }
}

if(! function_exists('package_path')) {
    function package_path($path = '') {
        return vendor_path('/ludows/adminify/'.$path);
    }
}

if(! function_exists('get_site_key')) {
    function get_site_key($key = '') {
        return config('site-settings.'.$key);
    }
}

if(! function_exists('is_admin')) {
    // we include auth services to admin area
    function is_admin() {
        $request = request();

        $pathables_admin = [
            'admin', 'login', 'register', 'password', 'email'
        ];

        return in_array('admin', $request->segments());
    }
}

if(! function_exists('is_editor_preview')) {
    function is_editor_preview() {
        $ret = false; 
        $isRunning = is_running_console();

        if(!$isRunning) {
            $r = request();

            $ret = $r->route()->getName() == 'editor.preview';
        }

        return $ret;
    }   
}

if(! function_exists('route_exist')) {
    function route_exist($name = '') {
        return Route::has($name);
    }
}


if(! function_exists('is_front')) {
    function is_front() {
        $request = request();
        $inertia = inertia();

        $pathables_admin = [
            'admin', 'login', 'register', 'password', 'email'
        ];

        if(empty($inertia->getShared('currentRouteSplitting'))) {
            return !in_array( $request->segment(1), $pathables_admin);
        }

        return !in_array('admin', $inertia->getShared('currentRouteSplitting'));
    }
}

if(! function_exists('get_missing_translations_routes') ) {
    function get_missing_translations_routes($model, $extraVarsRoute = []) {

        $request = request();

        $default_route_params = array_merge([
            'from' => $request->lang,
            'id' => $model->id,
            'model' => class_basename($model)
        ], $extraVarsRoute);

        $routeList = [];
        if($request->useMultilang && is_translatable_model($model)) {
            $miss = $model->getNeededTranslations();
            if(count($miss) > 0) {
                foreach ($miss as $missing) {
                    # code...
                    $default_route_params['to'] = $missing;

                    $routeList[] = route('savetraductions.edit', $default_route_params);

                }
            }
            // $default_route_params['lang'] =  ;
        }
        return $routeList;
    }
}

if(! function_exists('forget_cache')) {
    function forget_cache($key) {
        Cache::forget($key);
    }
}

if(!function_exists('cache_exist')) {
    function cache_exist($key) {
        return Cache::has($key);
    }
}

if(!function_exists('cache_flush')) {
    function cache_flush() {
        Cache::flush();
    }
}

if (! function_exists('setting')) {
    function setting($string = null) {
        $m = new Settings();

        if(is_null($string)) {
            return $m;
        }

        $q = $m->where('type', $string)->first();
        return $q != null ? $q->data : null;
    }
}

if(!function_exists('settings')) {
    function settings() {
        $m = new Settings();
        return $m->all();
    }
}

if (! function_exists('check_traductions')) {
    function check_traductions($array) {

        foreach ($array as $model) {
            # code...
            if(is_translatable_model($model)) {
                $model->checkForTraduction();
            }
        }
    }
}

if (! function_exists('is_sitemapable_model')) {
    function is_sitemapable_model($class) {
        return property_exists($class, 'sitemapTitle');
    }
}

if (! function_exists('translate')) {
    function translate($string = null) {
        $t = new Traduction();

        if(is_null($string)) {
            return $t;
        }

        $t = $t->key($string)->first();
        return $t != null ? $t->text : __($string);
    }
}

if(! function_exists('is_translatable_model')) {
    function is_translatable_model($class) {
        return method_exists($class,'getMultilangTranslatableSwitch');
    }
}

if(! function_exists('lang')) {
    function lang() {
        $isRunningConsole = is_running_console();
        $lang = app()->getLocale();
        $inertia = inertia();

        if(!$isRunningConsole) {
            $request = request();
            // dd( $request, $lang);
            // we check to get lang from request. if not provided like commands. We take current locale as fallback.
            if(!empty($inertia) && $inertia->getShared('currentLang')) {
                $lang = $inertia->getShared('currentLang');
            }
        }

        return $lang;
    }
}

if (! function_exists('menu')) {
    function menu($mixed) {
        $m = new Menu();

        if(is_null($mixed)) {
            return $m;
        }

        if(is_int($mixed)) {
            $m = $m->Id($mixed);
        }

        if(is_string($mixed)) {
            $m = $m->slug($mixed);
        }


        return $m->first();
    }
}

if(! function_exists('media')) {
    function media($mixed) {
        $m = new Media();
        
        if(is_null($mixed)) {
            return $m;
        }

        if(is_int($mixed)) {
            $m = $m->where('id', $mixed);
        }

        if(is_string($mixed)) {
            $m = $m->where('src', $mixed);
        }

        $result = $m->first();

        return !empty($result) ? $result : null;
    }
}

if(! function_exists('query')) {
    function query($model, $queryFunction) {
        return is_callable($queryFunction) ? $queryFunction($model) : null;
    }
}

if(! function_exists('storage')) {
    function storage($storage) {
        return Storage::disk($storage ?? 'public');
    }
}

if(! function_exists('image')) {
    function image($path, $parameters) {
        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/images/', env('GLIDE_SECURE_KEY'));

        // Generate a URL
        $url = $urlBuilder->getUrl($path, $parameters);

        return $url;
    }
}

if(! function_exists('glide')) {
    function glide() {
        // Get Glide server and return it.
        $g = app('League\Glide\Server');

        return $g;
    }
}

if (! function_exists('frontity_form')) {

    function frontity_form($namedClass, $templatePath = null, $html = true) {

        $c = config('site-settings.enables_features');

        if(isset($c['form']) && !$c['form']) {
            throw new Error('form feature must be enable to use frontity_form helper', 500);
        }

        $theClass = adminify_get_class($namedClass, ['app:forms:front'], false); 

        if(empty($theClass)) {
            throw new Error($theClass.' does not exist.', 500);
        }
        // $theForm = get_form($mixed);
        $renderer = '';
       
        $formBuilder = app('Kris\LaravelFormBuilder\FormBuilder');
        $v = view();

        $form = $formBuilder->create($theClass);

        $form->add('form_class', 'hidden', [
            'value' => $namedClass
        ]);


        if($html) {
            $isSubmit = session()->get('formSubmitted');
            $showForm = true;

            if(isset($form->show_form_when_validated) && $isSubmit) {
                $showForm = $form->show_form_when_validated;
            }

            if(empty($templatePath)) {
                $templatePath = $form->getView();
            }

            $renderer = $v->make( $templatePath , [
                'form' => $form,
                'showConfirmation' => $isSubmit ? true : false,
                'showForm' => $showForm,
            ])->render();
        }


        return $html ? $renderer : $form;
    }
}

if(!function_exists('status')) {
    function status() {
        return app('App\Adminify\Models\Statuses');
    }
}

if(! function_exists('hook_manager')) {
    function hook_manager() {
        return new HookManager();
    }
}

if(!function_exists('is_installed')) {
    function is_installed() {
        $pathable_extends = app_path('Adminify');
        return file_exists($pathable_extends) && is_dir($pathable_extends);
    }
}

if(! function_exists('get_content_types')) {
    function get_content_types() {
        $ret = [];
        $allModels = adminify_get_classes_by_folders(['app:adminify:models', 'app:models']);
        foreach ($allModels as $key => $model) {
            # code...
            $current_model = new $model;
            if(is_content_type_model($current_model) && is_sitemapable_model($current_model) && $current_model->allowSitemap) {
                $ret[$key] = $model;
            }

        }
        return $ret;
    }
}

if(! function_exists('front_registrar')) {
    function front_registrar() {
        return app()->make('Ludows\Adminify\Libs\FrontRouteRegistrar');
    }
}

if(! function_exists('is_collection')) {
    function is_collection($param): bool
    {
        return (bool) (($param instanceof \Illuminate\Support\Collection) || ($param instanceof \Illuminate\Database\Eloquent\Collection));
    }
}

if(!function_exists('is_route')) {
    function is_route($routeName = '', $array = []) {
        $curr_route = request()->route()->getName();
        if(!empty($array)) {
            $curr_route = $array;
        }

        if(is_array($curr_route)) {
            return in_array($routeName, $curr_route);
        }
        else {
            return $routeName == $curr_route;
        }
    }
}


