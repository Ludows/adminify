<?php

namespace Ludows\Adminify\Libs;

class HooksManager
{
    public function __construct($models, $datas = [])
    {
        $this->hooks = [];
        $this->request = request();
    }
    public function getHooks() {
        return $this->hooks;
    }
    public function getHooksByName(string $name = '') {
        return $this->hooks[$name];
    }
    public function exist($name = '') {
        return array_key_exists( $name, $this->getHooks() );
    }
    public function registerHook($name, $class) {

        //todo check class
        if(!array_key_exists($name, $this->hooks)) {
            $this->hooks[$name] = [];
        }

        $this->hooks[$name][] = $class;

    }
    public function registerHooks($name, $arrayClass) {

        foreach ($arrayClass as $class) {
            # code...
            $this->registerHook($name, $class);
        }

    }
}
