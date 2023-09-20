<?php

namespace Ludows\Adminify\Shortcodes;

use Error;
use Ludows\Adminify\Libs\ShortcodeBaseRender;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class FormShortcode extends ShortcodeBaseRender {
    public function render(ShortcodeInterface $s) {
        //dd('form shortcode');

        $adapter = null;
        $namedClassParam = $s->getParameter('namedClass');
        $optionsParam = $s->getParameter('options');

        if(empty($optionsParam)) {
            $optionsParam = '{}';
        }

        $theClass = adminify_get_class($namedClassParam, ['app:forms'], false);

        if(empty($theClass)) {
            throw new Error($theClass.' does not exist.', 500);
        }

        $formBuilder = app('Kris\LaravelFormBuilder\FormBuilder');
        $form = $formBuilder->create($theClass, json_decode($optionsParam));
        

        return form($form);

    }
}
