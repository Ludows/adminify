<?php

namespace Ludows\Adminify\Libs;

class AdminableToolbar
{
    public function __construct()
    {
        $this->menu = [];
        $this->view = view();
        $this->request = request();
    }

    public function getRequest() {
        return $this->request;
    }

    public function getView() {
        return 'adminify::layouts.front.toolbar.index';
    }
   
    public function render() {
        
        $this->menu = get_site_key('toolbar.menu');
       
        $compiled = $this->view->make( $this->getView() , [
            'items' => $this->menu
        ]);
       
        return $compiled;
    }
}
