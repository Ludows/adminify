<?php
use Thunder\Shortcode\ShortcodeFacade;
use App\Adminify\Models\Translations as Traduction;
use App\Adminify\Models\Forms;
use App\Adminify\Models\Menu;
use App\Adminify\Models\Settings;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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
        if($s != null && $class->id == $s && $class instanceof \App\Adminify\Models\Page) {
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
        if($s != null && $class->id == $s && $class instanceof \App\Adminify\Models\Page) {
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

        if($c != null) {
            $ret = $c;
        }
        return (bool) $ret;
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

if(! function_exists('get_site_key')) {
    function get_site_key($key = '') {
        return config('site-settings.'.$key);
    }
}

if(! function_exists('is_admin')) {
    function is_admin() {
        $request = request();

        return in_array('admin', $request->currentRouteSplitting);
    }
}

if(! function_exists('is_front')) {
    function is_front() {
        $request = request();

        return !in_array('admin', $request->currentRouteSplitting);
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
        // we check to get lang from request. if not provided like commands. We take current locale as fallback.
        $lang = $request->lang;
        return !empty($lang) ? $lang : app()->getLocale();
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

if (! function_exists('get_form')) {
    function get_form($mixed) {
        $m = new Forms();

        if(is_int($mixed)) {
            $m = $m->where('id', $mixed);
        }

        if(is_string($mixed)) {
            $m = $m->where('slug', $mixed);
            $m = $m->orWhere('title', $mixed);
        }


        return $m->get()->first();
    }
}

if (! function_exists('generate_form')) {

    function format_formbuilder_attributes($array) {


        $defaults = [
            'help_block' => [
                'text' => null,
                'tag' => 'p',
                'attr' => ['class' => 'help-block']
            ],
            'default_value' => null, // Fallback value if none provided by value property or model
            'value_property' => null, // Only use this if you want to take the default value from another property in the model
            'label_show' => true,
            'rules' => '',           // Validation rules
            'error_messages' => []   // Validation error messages
        ];

        foreach ($array as $arrayKey => $arrayValue) {
            # code...
            foreach ($arrayValue as $subArrayKey => $subArrayValue) {
                # code...
                if($arrayValue['required'] == true) {
                    $array[$arrayKey]['rules'] = 'required';
                }
                if($arrayValue['field_type'] != 'static') {
                    unset($array[$arrayKey]['content']);
                }
                else {
                    $array[$arrayKey]['value'] = $array[$arrayKey]['content'];
                    unset($array[$arrayKey]['content']);
                }

                if($subArrayKey == 'id') {
                    $array[$arrayKey]['name'] = 'field_'.$subArrayValue;
                    unset($array[$arrayKey]['id']);
                }

                if($subArrayKey == 'field_type') {
                    $array[$arrayKey]['type'] = $array[$arrayKey]['field_type'];
                    unset($array[$arrayKey]['field_type']);
                }

                if(in_array($subArrayKey, ['selected', 'choices'])) {
                    $array[$arrayKey][$subArrayKey] = json_decode($arrayValue[$subArrayKey], true);
                }
                if(in_array($subArrayKey, ['wrapper', 'attr', 'label_attr'])) {

                    $options = array();
                    $multilignes = explode(',', $array[$arrayKey][$subArrayKey]);

                    foreach ($multilignes as $multiligne) {
                        # code...
                        $multilignes = explode(':', $multiligne);

                        if(count($multilignes) > 1) {
                            $options[trim($multilignes[0])] = trim($multilignes[1]);
                        }
                    }

                    $array[$arrayKey][$subArrayKey] = $options;
                }
                if(in_array($subArrayKey, ['expanded', 'multiple', 'required', 'checked', 'label_show'])) {

                    $array[$arrayKey][$subArrayKey] = (boolean) $array[$arrayKey][$subArrayKey];
                }
            }

            // merge with defaults.
            $array[$arrayKey] = array_merge_recursive_distinct($defaults, $array[$arrayKey]);
        }

        return $array;
    }

    function generate_form($mixed, $html = true, $templatePath = null) {

        $theForm = get_form($mixed);
        $dynamics_fields = [];
        $renderer = '';
        $dynamic_form_config = get_site_key('dynamic_forms');
        $template = $dynamic_form_config['default_form_template'];

        $formBuilder = app('Kris\LaravelFormBuilder\FormBuilder');
        $v = view();

        if(empty($theForm)) {
            return null;
        }

        if(!empty($templatePath) && is_string($templatePath)) {
            $template = $templatePath;
        }


        $theFields = $theForm->fields->toArray();

        $dynamics_fields[] = [
            'name' => 'form_id',
            'type' => 'hidden',
            'value' => $theForm->id
        ];

        if(!empty($theFields)) {

            $casted_fields = format_formbuilder_attributes($theFields);
            // dd($casted_fields);

            foreach ($casted_fields as $casted_field) {
                # code...
                $dynamics_fields[] = $casted_field;
            }
        }

        $dynamics_fields[] = [
            'name' => 'submit',
            'type' => 'submit',
        ];

        $form = $formBuilder->createByArray(
            $dynamics_fields
            ,[
                'method' => 'POST',
                'url' => route('forms.validate')
            ]);


        if($html) {
            $isSubmit = session()->get('formSubmitted');
            $showForm = true;

            if(isset($dynamic_form_config['show_form_when_validated']) && $isSubmit) {
                $showForm = $dynamic_form_config['show_form_when_validated'];
            }

            $renderer = $v->make($template, [
                'form' => $form,
                'showConfirmation' => $isSubmit ? true : false,
                'showForm' => $showForm,
                'confirmation' => $theForm->confirmation->first()
            ])->render();
        }


        return $html ? $renderer : $form;
    }
}

