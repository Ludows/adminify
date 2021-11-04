<?php

namespace Ludows\Adminify\Shortcodes;

use Ludows\Adminify\Libs\ShortcodeBaseRender;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class FormShortcode extends ShortcodeBaseRender {
    public function render(ShortcodeInterface $s) {
        dd('form shortcode');
    }
}
