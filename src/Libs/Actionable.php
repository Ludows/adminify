<?php

namespace Ludows\Adminify\Libs;

class Actionable
{
    public function __construct($model, $datas = [])
    {
        $this->actions = [];
        $this->view = view();
        $this->datas = isset($datas) ? $datas : null;
        $this->request = request();
        $this->model = isset($model) ? $model : null;
        $this->handle();
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
    public function getModel() {
        return $this->model;
    }
    public function hasModel() {
        return $this->model != null;
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
    public function handle() {}
    public function render() {
        $actions = $this->getActions();
        $tpl = $this->getView();
        $compiled = $this->view->make($tpl, ['actions' => $actions]);
        return $compiled;
    }
}
