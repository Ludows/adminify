<?php
namespace Ludows\Adminify\Libs;

class AdminMenuService {

    private $items;
    private $active_class;
    private $resolver;
    private $request;
    public function __construct() {
        $this->items = [];
        $this->active_class = '';
        $this->resolver = get_site_key('adminMenu');
        $this->request = request();
    }
    public function getDefaultsSettingsItems():array {
        return [
            'icon' => '',
            'baseIconClass' => 'bi',
            'iconPrefix' => 'bs-',
            'is-active' => false,
            'url' => '',
            'label' => '',
            'attributes' => [],
            'childs' => []
        ];
    }
    public function getRequest() {
        return $this->request;
    }
    public function getActiveClass() {
        return $this->active_class;
    }
    public function getItems() {
        return $this->items;
    }
    public function getResolver() {
        return $this->resolver;
    }
    public function setResolver($mixed) {
        $this->resolver = $mixed;
    }
    public function setActiveClass($string = '') {
        $this->active_class = $string;
    }
    public function setItem($identifier = '', $datas = []):void {
        $defaults = $this->getDefaultsSettingsItems();
        $this->items[$identifier] = array_merge($defaults, $datas);
    }
    public function setItems($arrayofItems = []):void {
        if(is_array($arrayofItems)) {
            foreach ($arrayofItems as $key => $item) {
                # code...
                $this->setItem($key, $item);
            }
        }
    }
    public function add($identifier = '', $datas = []) {
        if(!empty($identifier)) {
            $this->setItem($identifier, $datas);
        }
        return $this;
    }
    public function resolve($datas = []) {
        $menu_config = $this->getResolver();
        foreach ($menu_config as $menu_str) {
            # code...
            $menu_class = app( adminify_get_class($menu_str, ['app:adminify:models', 'app:models'], false) );

            if($menu_class && $menu_class->showInMenu) {
                $r = call_user_func_array( array($menu_class, 'getLinks'), array($this, $datas) );
            }
        }
    }
}
