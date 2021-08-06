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

    private function loopThroughtPaths(array $arrayOfItems = [], $request) {
        
        foreach ($arrayOfItems as $menuItem) {
            if(isset($menuItem['key_title'])) {
                $menuItem['title'] = __($menuItem['key_title']);
                unset($menuItem['key_title']);
            }
            if(isset($menuItem['url']) && $menuItem['url'] instanceof Closure && $request != null) {
                $menuItem['url'] = $menuItem['url']($request);
            }
            if(isset($menuItem['paths']) && is_array($menuItem['paths']) && !empty($menuItem['paths'])) {
                $this->loopThroughtPaths($menuItem['paths'], $request);
            }
        }
    }
   
    public function render() {
        
        $this->menu = get_site_key('toolbar.menu');
        
        $r = $this->getRequest();

        $this->loopThroughtPaths($this->menu, $r);
       
        $compiled = $this->view->make( $this->getView() , [
            'items' => $this->menu
        ]);
       
        return $compiled;
    }
}
