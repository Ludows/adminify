<?php

namespace Ludows\Adminify\Libs;

class Dropdowns
{
    public function __construct($models, $datas = [])
    {
        $this->actions = [];
        $this->view = view();
        $this->datas = isset($datas) ? $datas : null;
        $this->request = request();
        $this->models = isset($models) ? $models : [];
        
        $ref = new ReflectionMethod($this, 'handle');
        $this->handle(...$ref);
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
    public function getActions() {
        return $this->actions;
    }
    public function getModels() {
        return $this->models;
    }
    public function hasModels() {
        return $this->model != [];
    }
    public function getAction($name = '') {
        return $this->actions[$name];
    }
    public function setAction($name = '', $params = []) {
        $this->actions[$name] = $params;
        return $this;
    }
    public function removeAction($name = '') {
        unset($this->actions[$name]);
        return $this;
    }
    public function add($name = '', $params = []) {
        $this->setAction($name, array_merge($this->setDefaults(), $params));
        return $this;
    }
    public function getView() {
        return 'adminify::layouts.admin.actionable.dropdown';
    }
    public function remove($name = '') {
        $this->removeAction($name);
        return $this;
    }
    public function handle(...$parameters) {}
    public function render() {
        $actions = $this->getActions();
        $tpl = $this->getView();
        $compiled = $this->view->make($tpl, ['actions' => $actions]);
        return $compiled;
    }
}
