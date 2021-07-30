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
        $this->show = true;
        $this->limit = $this->limit();
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

    public function limit() {
        return -1;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setLimit($value = -1) {
        $this->limit = $value;
        return $this;
    }

    public function setShow($value = true) {
        $this->show = $value;
        return $this;
    }

    public function getShow() {
        return $this->show;
    }

    public function getQuery() {
        return $this->query;
    }

    public function setQuery($value = null) {
        $this->query = $value;
        return $this;
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

    public function hasRoles() {
        return is_array($this->roles) && count($this->roles) > 0 ? true : false;
    }

    public function show() {

        $show = $this->getShow();
        $hasRoles = $this->hasRoles();
        $return = $show;
        $u = user();

        if($hasRoles && !$u->hasRoles( $this->getRoles() )) {
            $return = false;
        }

        return $return;
    }

    public function css($cssPath) {
        $this->css[] = $cssPath;
        return $this;
    }

    public function showColumn() {
        return 'title';
    }

    public function getPlural() {
        return '';
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
            'show' => $this->showColumn(),
            'plural' => $this->getPlural(),
            'type' => Str::singular( $this->getPlural() ),
            'css' => $this->getCss(),
            'js' => $this->getJs(),
            'query' => $query
        ];

        $compiled = '';

        if($this->show()) {
            $compiled = $this->view->make($tpl, array_merge( $defaults, $this->addToRender()));
        }

        return $compiled;
    }
}
