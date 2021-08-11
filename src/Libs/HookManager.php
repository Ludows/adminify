<?php

namespace Ludows\Adminify\Libs;

class HookManager
{
    public function __construct()
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
    public function run($name) {

        $hooks = $this->getHooksByName($name);

        if($hooks != null && count($hooks) > 0) {
            foreach ($hooks as $hook) {
                # code...

                $r = call_user_func(array($hook, 'handle'));

            }
        }

        return $this;
    }
    public function registerHooks($name, $arrayClass) {

        foreach ($arrayClass as $class) {
            # code...
            $this->registerHook($name, $class);
        }

    }
}
