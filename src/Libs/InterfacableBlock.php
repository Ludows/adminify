<?php

namespace Ludows\Adminify\Libs;
use Illuminate\Support\Str;

class InterfacableBlock
{
    public function __construct()
    {
        $this->view = view();
        $this->request = request();
        $this->model = null;
        $this->js = [];
        $this->css = [];
        $this->roles = [];
        $this->query = null;
        $this->enableRoles = false;
        $this->show = true;
    }
    public function getModel() {
        return $this->model;
    }
    public function hasModel() {
        return $this->model != null;
    }
    public function setModel($model) {
        $this->model = $model;
        return $this;
    }

    public function getQuery() {
        return $this->query;
    }

    public function query() {

    }

    public function model($model) {
        return $this->setModel($model);
    }

    public function js($jsPath) {
        $this->js[] = $jsPath;
        return $this;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function roles($array) {
        array_merge($this->roles, $array);
        return $this;
    }

    public function show() {

        $return = $this->show;

        if($this->enableRoles && $this->show) {
            $return = $this->enableRoles;
        }

        return $return;
    }

    public function css($cssPath) {
        $this->css[] = $cssPath;
        return $this;
    }

    public static function getNamedBlock() {
        return '';
    }

    public function getRequest() {
        return $this->request;
    }

    public function getView() {
        return 'adminify::layouts.admin.interfacable.card';
    }

    public function getJs() {
        return $this->js;
    }

    public function getCss() {
        return $this->css;
    }

    public function addToRender() {
        return [];
    }

    public function getBlocks() {
        return $this->blocks;
    }

    public function handle() {}
    public function render() {
        
        $tpl = $this->getView();
        $query = $this->getQuery();

        $defaults = [
            'css' => $this->getCss(), 
            'js' => $this->getJs(),
            'query' => $query
        ];

        $compiled = $this->view->make($tpl, array_merge( $defaults, $this->addToRender()));
        return $compiled;
    }
}
