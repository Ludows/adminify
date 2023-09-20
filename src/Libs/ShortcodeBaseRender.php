<?php
namespace Ludows\Adminify\Libs;

use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use Thunder\Shortcode\HandlerContainer\HandlerContainer;
use Thunder\Shortcode\Parser\RegularParser;
use Thunder\Shortcode\Processor\Processor;

class ShortcodeBaseRender {

    public function __construct($datas) {
        // $this->s = app(ShortcodeInterface::class);
        $this->handler = new HandlerContainer();
        $this->datas = $datas;
        $this->parsed = $this->wireElement();
    }

    public function wireElement() {
        // dd($this->datas['shortcodeClass'].'@render');
        $this->handler->add($this->datas['shortcodeName'], array($this,'render'));

        $processor = new Processor(new RegularParser(), $this->handler);

        $text = $this->datas['text'];

        return $processor->process($text);
    }

    public function getParsedAttribute() {
        return $this->parsed;
    }

    public function render(ShortcodeInterface $s) {
        //make your magic shortcode here..
        return 'ok';
    }
}
