<?php

namespace Ludows\Adminify\Libs;
use Ludows\Adminify\Libs\Dropdown;
use Illuminate\Support\Str;
class TableManager
{
    public function __construct()
    {
        $this->view = view();
        $this->datas = [];
        $this->request = request();
        $this->model = null;
        $this->columns = [];
        $this->items = [];
        $this->_columns = [];
        $this->js = [];
        $this->css = [];
        $this->areas = [
            'top-left' => [],
            'top-right' => [],
            'bottom-left' => [],
            'bottom-right' => []
        ];
        $this->showTitle = true;
        $this->showSearch = true;
        $this->showBtnCreate = true;
    }
    public function setColumns($value = []) {
        $this->columns = $value;
        return $this;
    }

    public function getColumns() {
        return $this->columns;
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

    public function module($name, $position, $viewName, $extraVars) {

        if(!isset($position)) {
            $position = 'top-left';
        }

        if(!isset($extraVars)) {
            $extraVars = [];
        }

        if(isset($this->areas[$position])) {
            $this->setToArea($name, $position, view($viewName, $extraVars));
        }

        return $this;
    }

    public function setToArea($name, $position, $view) {

        $this->areas[$position][$name] = $view;

        return $this;

    }

    public function model($model) {
        return $this->setModel($model);
    }

    public function columns($a = []) {
        $this->columns = $a;

        foreach ($a as $col) {
            # code...
            $this->_columns[$col] = [];
        }

        return $this;
    }

    public function datas($name, $value) {
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

    public function options($array) {
        if(is_array($array)) {
            $array_keys = array_keys($array);
            if(count($array_keys) > 0) {
                foreach ($array_keys as $keyable) {
                    # code...
                    $this->{$keyable} = $array[$keyable];
                }
            }
        }
        return $this;
    }

    public function column($name, $viewName, $extraVars = []) {

        $v = $viewName;
        if(is_null($viewName)) {
            $v = 'adminify::layouts.admin.table.cell';
        }

        $this->_columns[ Str::slug($name) ][] = (object) [
            'view' => $v,
            'vars' => array_merge($extraVars, ['model' => $this->getModel(), 'attr' => $name]),
        ];
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
        return 'adminify::layouts.admin.table.index';
    }

    public function getViewList() {
        return 'adminify::layouts.admin.table.datalist';
    }

    public function getJs() {
        return $this->js;
    }

    public function getCss() {
        return $this->css;
    }

    public function addVarsToRender() {
        return [];
    }

    public function getAreas() {
        return $this->areas;
    }

    public function handle() {}
    public function render() {

        $listings = get_site_key('register');        
        $name = $this->getRequest()->route()->getName();
        $name = str_replace('.index', '', $name);

        $singular = singular( $name );

        if($this->showTitle) {
            $this->module('title', 'top-left', 'adminify::layouts.admin.table.core.title');
        }

        if($this->showSearch) {
            $this->module('search', 'top-right', 'adminify::layouts.admin.table.core.search', [
                'showSearchBar' => isset($listings[ $singular ]) ? true : false,
                'showCreate' => $this->showBtnCreate
            ]);
        }

        $this->handle();

        $tpl = $this->getView();
        $cols = $this->getColumns();
        $areas = $this->getAreas();

        $classModel = get_site_key('register.'.$singular);
        $count = null;

        if($classModel != null) {
            $classModel = new $classModel;
            $count = $classModel->count();
        }


        $defaults = [
            'datas' => $this->_columns,
            'thead' => $cols,
            'total' => $count,
            'count' => count($this->_columns[$cols[0]]),
            'css' => $this->getCss(),
            'js' => $this->getJs(),
            'name' => $name,
            'areas' => $areas
        ];



        $addtoVars = $this->addVarsToRender();

        $compiled = $this->view->make($tpl, array_merge($defaults, $addtoVars));
        return $compiled;
    }
    public function list() {

        $this->handle();

        $cols = $this->getColumns();
        $addtoVars = $this->addVarsToRender();

        $name = $this->getRequest()->route()->getName();
        $name = str_replace('.index', '', $name);

        $defaults = [
            'datas' => $this->_columns,
            'thead' => $cols,
            'count' => count($this->_columns[$cols[0]]),
            'name' => $name
        ];

        $compiled = $this->view->make( $this->getViewList() , array_merge($defaults, $addtoVars) );
        return $compiled;
    }
}
