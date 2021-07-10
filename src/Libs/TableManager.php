<?php

namespace Ludows\Adminify\Libs;
use Ludows\Adminify\Libs\Dropdown;

class TableManager
{
    public function __construct()
    {
        $this->view = view();
        $this->datas = null;
        $this->request = request();
        $this->model = null;
        $this->th = [];

        $this->handle();
    }
    public function setTh($value = []) {
        $this->th = $value;
        return $this;
    }

    public function getTh() {
        return $this->th;
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

    public function column($name, $view) {
        
    }

    public function setDefaults() {
        return [
            'template' => 'adminify::layouts.admin.table.item',
            'vars' => []
        ];
    }
    public function getRequest() {
        return $this->request;
    }
    public function getDatas() {
        return $this->datas;
    }
    public function hasDatas() {
        return $this->datas != null;
    }
    public function setDatas($value) {
        $this->datas = $value;
    }
    public function removeDatas() {
        $this->datas = null;
    }
    public function add($name = '', $params = []) {
        // $this->setDropdown($name, array_merge($this->setDefaults(), $params));
        return $this;
    }
    public function getView() {
        return 'adminify::layouts.admin.table';
    }
    public function remove($index = 0) {
        // $this->removeDropdown($index);
        return $this;
    }
    public function handle() {}
    public function render($index) {

        if($index != null) {
            $dropdowns = [$this->getDropdown('dropdown_'.$index)];
        }
        else {
            $dropdowns = $this->getDropdowns();
        }

        $tpl = $this->getView();
        $compiled = $this->view->make($tpl, ['dropdowns' => $dropdowns]);
        return $compiled;
    }
}
