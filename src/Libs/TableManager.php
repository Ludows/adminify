<?php

namespace Ludows\Adminify\Libs;
use Ludows\Adminify\Libs\Dropdown;

class TableManager
{
    public function __construct($autoHandle = true)
    {
        $this->view = view();
        $this->datas = [];
        $this->request = request();
        $this->model = null;
        $this->columns = [];
        $this->items = [];
        $this->_columns = [];

        if($autoHandle) {
            $this->handle();
        }
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

    public function datas($name = null, $value) {
        $this->datas[$name] = $value;
        return $this;
    }

    public function column($name, $viewName, $extraVars = []) {

        $v = $viewName;
        if(is_null($viewName)) {
            $v = 'adminify::layouts.admin.table.cell';
        }

        $this->_columns[$name][] = (object) [
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

    public function handle() {}
    public function render() {

        $tpl = $this->getView();
        $cols = $this->getColumns();
        $compiled = $this->view->make($tpl, ['datas' => $this->_columns, 'thead' => $cols, 'count' => count($this->_columns[$cols[0]]) ]);
        return $compiled;
    }
    public function list() {
        $cols = $this->getColumns();
        $compiled = $this->view->make( $this->getViewList() , ['datas' => $this->_columns,'thead' => $cols, 'count' => count($this->_columns[$cols[0]]) ]);
        return $compiled;
    }
}
