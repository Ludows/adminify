<?php

namespace Ludows\Adminify\Libs;

class Dropdowns
{
    public function __construct()
    {
        $this->items = [];
        $this->view = view();
        $this->request = request();
        $this->handle();
    }

    public function getRequest() {
        return $this->request;
    }
    public function getItems() {
        return $this->items;
    }
    public function setItems($array) {

    }
    public function getItem($name = '') {
        return $this->items[$name];
    }
    public function getItemView() {
        return 'adminify::layouts.admin.actionable.dropdown';
    }
    public function handle() {}
    public function render() {
        $actions = $this->getItems();
        $tpl = $this->getItemView();
        $compiled = $this->view->make($tpl, ['actions' => $actions]);
        return $compiled;
    }
}
