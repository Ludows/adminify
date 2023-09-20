<?php

namespace Ludows\Adminify\Libs;
use Closure;
use Illuminate\Support\Facades\Route;

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
        return 'adminify::layouts.modules.toolbar';
    }

    private function callMethodOrClass($class, $arrayMap, $param) {
        $clsClass = $class;
        $return_data = null;
        $withMethod = false;
        if(strrpos($arrayMap['dynamic_'.$param], '@')) {
            $clsClass = explode('@', $clsClass);
            $withMethod = true;
        }

        if($withMethod) {
            $return_data = call_user_func(array($clsClass[0], $clsClass[1]));
        }
        else {
            $return_data = call_user_func($clsClass);
        }
        $arrayMap[$param] = $return_data;
        unset($arrayMap['dynamic_'.$param]);
        return $arrayMap;
    }

    private function loopThroughtPaths(array $arrayOfItems = []) {


        foreach ($arrayOfItems as $menuKey => $menuItem) {

            $menuItem['show'] = true;

            if(isset($menuItem['key_title'])) {
                $menuItem['title'] = __($menuItem['key_title']);
                unset($menuItem['key_title']);
            }

            if(isset($menuItem['key_url']) && Route::has($menuItem['key_url'])) {
                $menuItem['url'] = route($menuItem['key_url']);
                unset($menuItem['key_url']);
            }

            if(isset($menuItem['dynamic_show'])) {
                $menuItem = $this->callMethodOrClass($menuItem['dynamic_show'], $menuItem, 'show');
            }

            if(isset($menuItem['dynamic_url'])) {
                $menuItem = $this->callMethodOrClass($menuItem['dynamic_url'], $menuItem, 'url');
            }

            if(isset($menuItem['paths']) && is_array($menuItem['paths']) && !empty($menuItem['paths'])) {
                $paths = $this->loopThroughtPaths($menuItem['paths']);
                unset($menuItem['paths']);
                $menuItem['paths'] = $paths;
            }
            $arrayOfItems[$menuKey] = $menuItem;
        }

        return $arrayOfItems;
    }

    public function render() {

        $this->menu = $this->loopThroughtPaths( get_site_key('toolbar.menu') );

        $compiled = $this->view->make( $this->getView() , [
            'items' => $this->menu
        ]);

        return $compiled;
    }

    public function userEdit() {
        $u = user();
        return route('users.edit', ['user' => $u->id]);
    }
    public function userProfile() {
        $u = user();
        return route('users.profile.edit', ['user' => $u->id]);
    }
    public function modify() {
        $r = $this->getRequest();
        $plural = plural( lowercase( class_basename( $r->model ) ) );
        $singular = singular( lowercase( class_basename( $r->model ) ) );

        return route($plural.'.edit', [$singular => $r->model->id]);
    }
    public function newComment() {
        return true;
    }
}
