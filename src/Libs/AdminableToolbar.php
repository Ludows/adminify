<?php

namespace Ludows\Adminify\Libs;
use Closure;

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

    private function loopThroughtPaths(array $arrayOfItems = []) {
        
        foreach ($arrayOfItems as $menuItem) {
            if(isset($menuItem['key_title'])) {
                $menuItem['title'] = __($menuItem['key_title']);
                unset($menuItem['key_title']);
            }
            if(isset($menuItem['key_url'])) {
                $menuItem['url'] = route($menuItem['key_url']);
                unset($menuItem['key_url']);
            }
            if(isset($menuItem['url']) && $menuItem['url'] instanceof Closure) {
                $menuItem['url'] = $menuItem['url']();
            }
            if(isset($menuItem['paths']) && is_array($menuItem['paths']) && !empty($menuItem['paths'])) {
                $this->loopThroughtPaths($menuItem['paths']);
            }
        }
    }
   
    public function render() {
        
        $this->menu = get_site_key('toolbar.menu');
        
        $this->loopThroughtPaths($this->menu);
       
        $compiled = $this->view->make( $this->getView() , [
            'items' => $this->menu
        ]);
       
        return $compiled;
    }
}
