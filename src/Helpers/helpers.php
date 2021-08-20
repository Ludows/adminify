<?php
use Thunder\Shortcode\ShortcodeFacade;
use App\Models\Translations as Traduction;
use App\Models\Menu;
use App\Models\Settings;
use Illuminate\Support\Facades\Cache;

if (! function_exists('do_shortcode')) {
    function do_shortcode($shortcodeName, $parameters = []) {
        $shortcodes = config('site-settings.shortcodes');

        $shortcode = $shortcodes[$shortcodeName];
        $text = '['. $shortcodeName;

        if(count($parameters) > 0) {
            foreach ($parameters as $parameterName => $value) {
                # code...
                $text .= ' '.$parameterName.'="'.$value.'"';
            }
        }

        $text .= ']';

        $shortcodeClass = new $shortcode([
            'text' => $text,
            'shortcodeName' => $shortcodeName,
            'shortcodeClass' => $shortcode
        ]);

        return $shortcodeClass->parsed;
    }
}

if (! function_exists('parse_shortcode')) {
    function parse_shortcode($string = '') {
        $parser = new ShortcodeFacade();
        $result = $parser->parse($string);
        //dd($result);
        return $result;
    }
}

if(! function_exists('is_linkable_media_model') ) {
    function is_linkable_media_model($class) {
        // the relationship model
        return method_exists($class, 'media');
    }
}

if(! function_exists('is_homepage') ) {
    function is_homepage($class) {
        // the relationship model
        $ret = false;
        $s = setting('homepage');
        if($s != null && $class->id == $s && $class instanceof \App\Models\Page) {
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
        if($s != null && $class->id == $s && $class instanceof \App\Models\Page) {
            $ret = true;
        }
        return $ret;
    }
}

if(! function_exists('is_trashable_model')  ) {
    function is_trashable_model($class) {
        // the relationship model
        $f = $class->getFillable();
        return in_array('status_id', $f);
    }
}

if(! function_exists('set_recursive_finder')) {
    function set_recursive_finder($path, $wantedFile, $params = []) {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        $ret = $params['startValue'];
        foreach ($rii as $file)
            if ($file->isDir()) {
                set_recursive_finder($file, $wantedFile, $params);
            }

            if($file->getPathname() == $wantedFile) {
                $ret = $params['endValue'] ?? $file->getPathname();
            }

        return $ret;
    }
}


if(! function_exists('search_stubs_install')) {
    function search_stubs_install($path, $wantedFile) {
        $ret = set_recursive_finder($path, $wantedFile, [
            'startValue' => null,
        ]);
        return $ret;
    }
}

if(! function_exists('is_installed_stub')) {
    function is_installed_stub($path, $wantedFile) {
        $ret = set_recursive_finder($path, $wantedFile, [
            'startValue' => false,
            'endValue' => true,
        ]);
        return $ret;
    }
}

if(! function_exists('get_missing_langs')) {
    function get_missing_langs($model) {
        $request = request();
        $langs = [];
        if($request->useMultilang && is_translatable_model($model)) {
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

if(! function_exists('get_model_by')) {
    function get_model_by($modelNamespace, $column, $value = '', $operator = '=') {
        $m = new $modelNamespace();
        $m = $m->where($column, $operator, $value)->get()->all();
        return $m;
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

        $cacheUser = null;
        $id = auth()->id();

        if($id != null) {
            $cacheUser = cache('user-'. $id);

            if($cacheUser == null) {
                $cacheUser = cache(['user-'. $id => auth()->user()]);
            }
        }

        return $cacheUser;
    }
}

if(! function_exists('get_site_key')) {
    function get_site_key($key = '') {
        return config('site-settings.'.$key);
    }
}

if(! function_exists('get_missing_translations_routes') ) {
    function get_missing_translations_routes($routeName, $singular, $model, $extraVarsRoute = []) {

        $request = request();

        $reflect = new \ReflectionClass($model);

        $namepace = explode('\\', strtolower( $reflect->name ) );

        $default_route_params = array_merge([
            $singular => $model->id,
            'from' => $request->lang,
            'type' => Str::singular($namepace[count($namepace) - 1])
        ], $extraVarsRoute);

        $routeList = [];
        if($request->useMultilang && is_translatable_model($model)) {
            $miss = $model->getNeededTranslations();
            if(count($miss) > 0) {
                foreach ($miss as $missing) {
                    # code...
                    $default_route_params['lang'] = $missing;

                    $routeList[] = route($routeName, $default_route_params);

                }
            }
            // $default_route_params['lang'] =  ;
        }
        return $routeList;
    }
}

if (! function_exists('get_shortcode')) {
    function get_shortcode($string = '') {
        $ret_s = null;
        $name = $string;
        $shortcodes = config('site-settings.shortcodes');

        if(isset($shortcodes[$name])) {
            $ret_s = [
                'name' => $name,
                'class' => $shortcodes[$name]
            ];
        }
        return $ret_s;
    }
}

if(! function_exists('forget_cache')) {
    function forget_cache($key) {
        Cache::forget($key);
    }
}

if (! function_exists('is_shortcode')) {
    function is_shortcode($string = '') {

        $isShortcode = false;
        $name = $string;
        $shortcodes = config('site-settings.shortcodes');

        if(isset($shortcodes[$name])) {
            $isShortcode = true;
        }
        return $isShortcode;
    }
}

if (! function_exists('setting')) {
    function setting($string) {
        $m = new Settings();
        $q = $m->where('type', $string)->first();
        return $q != null ? $q->data : null;
    }
}

if (! function_exists('render_dropdowns')) {
    function render_dropdowns($array) {
        $i = 0;
        foreach ($array as $a) {
            # code...
            return $a->render($i ? $i : null);
            $i++;
        }
    }
}

if (! function_exists('render_dropdown')) {
    function render_dropdown($class, $index) {
        return $class->render($index ? $index : null);
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

if (! function_exists('get_translation')) {
    function get_translation($string) {
        $t = new Traduction();
        $t = $t->key($string)->first();
        return $t != null ? $t->text : null;
    }
}

if (! function_exists('menu_builder')) {
    function menu_builder($class) {
        return $class->render();
    }
}

if(! function_exists('add_to_request')) {
    function add_to_request($key, $value) {
        $request = request();
        $request->{$key} = $value;
    }
}

if(! function_exists('merge_to_request')) {
    function merge_to_request($key, $value) {
        $request = request();
        if($request->{$key}) {
            $request->{$key} = $value;
        }
        $request->{$key} = $value;
    }
}

if(! function_exists('is_translatable_model')) {
    function is_translatable_model($class) {
        return method_exists($class,'getMultilangTranslatableSwitch');
    }
}

if(! function_exists('lang')) {
    function lang() {
        $request = request();
        return $request->lang;
    }
}

if (! function_exists('menu')) {
    function menu($mixed) {
        $m = new Menu();

        if(is_int($mixed)) {
            $m = $m->Id($mixed);
        }

        if(is_string($mixed)) {
            $m = $m->slug($mixed);
        }


        return $m->first()->makeThree;
    }
}

