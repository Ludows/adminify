<?php

namespace Ludows\Adminify\Libs;
use Illuminate\Support\Str;

class InterfacableManager
{
    public function __construct()
    {
        $this->view = view();
        $this->datas = [];
        $this->request = request();
        $this->blocks = [];
        $this->js = [];
        $this->css = [];
    }

    // ex $this->registerBlocks('tata', 'MaSuperClasse');

    public function registerBlock($name, $phpClass = null, $autoHandle = true) {

        $block = new $phpClass;
        if(is_null($phpClass)) {

        }

        if($autoHandle) {
            $block->setQuery( $block->query() );
            $block->handle();
        }

        $this->blocks[ Str::slug($name) ] = $block;
        return $this;
    }

    public function datas($name = null, $value) {
        $this->datas[$name] = $value;
        return $this;
    }

    public function js($jsPath) {
        $this->js[] = $jsPath;
        return $this;
    }

    public function css($cssPath) {
        $this->css[] = $cssPath;
        return $this;
    }

    public function getRequest() {
        return $this->request;
    }
    public function getDatas() {
        return $this->datas;
    }
    public function hasDatas() {
        return count($this->datas) != 0;
    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.index';
    }

    public function getJs() {
        return $this->js;
    }

    public function getCss() {
        return $this->css;
    }

    public function getBlocks() {
        return $this->blocks;
    }

    public function render() {

        $tpl = $this->getView();
        $blocks = $this->getBlocks();
        $compiled = $this->view->make($tpl, ['blocks' => $blocks, 'css' => $this->getCss(), 'js' => $this->getJs() ]);
        return $compiled;
    }
}
