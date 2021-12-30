<?php

namespace Ludows\Adminify\Shortcodes;

use Ludows\Adminify\Libs\ShortcodeBaseRender;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

use App\Adminify\Models\Templates;

class TemplateShortcode extends ShortcodeBaseRender {
    public function render(ShortcodeInterface $s) {
        //dd('form shortcode');

        $adapter = null;
        $idParam = $s->getParameter('id');
        // $elementParam = $s->getParameter('slug');
        // $templateParam = $s->getParameter('template');
        // $dynamic_form_config = get_site_key('dynamic_forms');
        // $template = $dynamic_form_config['default_form_template'];


        if(empty($idParam)) {
            return '';
        }

        if($idParam != null) {
            $adapter = (int) $idParam;
        }

        $m = new Templates();
        $m = $m->find($adapter);

        return $m->content;

    }
}
