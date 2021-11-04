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

        if(empty($idParam) && empty($elementParam)) {
            return '';
        }

        if($idParam != null) {
            $adapter = (int) $idParam;
        }
        else {
            $adapter = $elementParam;
        }

        return generate_form($adapter);

    }
}
