<?php

namespace Ludows\Adminify\Libs;

class Dropdown
{
    public function __construct()
    {
        $this->items = [];
        $this->view = view();
        $this->request = request();
    }

    public function getRequest() {
        return $this->request;
    }
    public function getItems() {
        return $this->items;
    }
    public function setItem($items) {
        $this->items[] = $items;
        return $this;
    }
    public function getItem($name = '') {
        return $this->items[$name];
    }
    public function handle() {}
    public function render() {
        
        $this->handle();

        $items = $this->getItems();
        $compiled = '';

        foreach ($items as $item) {
            # code...
            $compiled .= $this->view->make($item['tpl'], $item['vars']);
        }

       
        return $compiled;
    }
}
