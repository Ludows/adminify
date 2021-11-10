<?php

namespace Ludows\Adminify\Shortcodes;

use Ludows\Adminify\Libs\ShortcodeBaseRender;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class FormShortcode extends ShortcodeBaseRender {
    public function render(ShortcodeInterface $s) {
        //dd('form shortcode');

        $adapter = null;
        $idParam = $s->getParameter('id');
        $elementParam = $s->getParameter('element');
        $templateParam = $s->getParameter('template');
        $dynamic_form_config = get_site_key('dynamic_forms');
        $template = $dynamic_form_config['default_form_template'];


        if(empty($idParam) && empty($elementParam)) {
            return '';
        }

        if($idParam != null) {
            $adapter = (int) $idParam;
        }
        else {
            $adapter = $elementParam;
        }

        if(!empty($templateParam) && is_string($templateParam)) {
            $template = $templateParam;
        }

        return generate_form($adapter, true, $template);

    }
}
