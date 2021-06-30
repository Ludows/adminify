<?php

namespace Ludows\Adminify\Libs;
use Ludows\Adminify\Libs\Dropdown;

class DropdownsManager
{
    public function __construct($models, $datas = [])
    {
        $this->dropdowns = [];
        $this->view = view();
        $this->datas = isset($datas) ? $datas : null;
        $this->request = request();
        $this->models = isset($models) ? $models : [];
    }

    public function setDefaults() {
        return [
            'template' => '',
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
    public function getDropdowns() {
        return $this->dropdowns;
    }
    public function getModels() {
        return $this->models;
    }
    public function exists($name = '') {
        return array_search( $name, $this->getDropdowns() );
    }
    public function hasModels() {
        return $this->model != [];
    }
    public function getDropdown($index = 0) {
        return $this->dropdowns[$index];
    }
    public function setDropdown($name = '', $params = [], $group = null) {
        if($group != null) {
            $this->actions[$group][$name] = $params;
        }
        else {
            $this->actions[$name] = $params;
        }
        return $this;
    }
    public function removeDropdown($index = 0) {
        unset($this->dropdowns[$index]);
        return $this;
    }
    public function add($name = '', $params = [], $group = null) {
        $this->setDropdown($name, array_merge($this->setDefaults(), $params));
        return $this;
    }
    public function getView() {
        return 'adminify::layouts.admin.actionable.dropdown';
    }
    public function remove($index = 0) {
        $this->removeDropdown($index);
        return $this;
    }
    public function handle() {}
    public function render() {

        $this->handle();

        $dropdowns = $this->getDropdowns();
        $tpl = $this->getView();
        $compiled = $this->view->make($tpl, ['dropdowns' => $dropdowns]);
        return $compiled;
    }
}
