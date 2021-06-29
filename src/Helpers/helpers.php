<?php
use Thunder\Shortcode\ShortcodeFacade;
use Ludows\Adminify\Models\Translations as Traduction;
use Ludows\Adminify\Models\Menu;
use Ludows\Adminify\Models\Settings;

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
        return $parser->parse($string)[0];
    }
}

if (! function_exists('get_shortcode')) {
    function get_shortcode($string = '') {
        $ret_s = null;
        $name = parse_shortcode($string)->getName();
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

if (! function_exists('is_shortcode')) {
    function is_shortcode($string = '') {

        $isShortcode = false;
        $name = parse_shortcode($string)->getName();
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

if (! function_exists('render_actions')) {
    function render_actions($array) {
        foreach ($array as $a) {
            # code...
            return $a->render();
        }
    }
}

if (! function_exists('render_action')) {
    function render_action($class) {
        return $class->render();
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
