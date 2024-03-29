<?php

namespace Ludows\Adminify\Libs;

use Error;

class HookManager
{
    public function __construct()
    {
        $this->hooks = config('site-settings.hooks');
        $this->request = request();
    }
    public function getInstance() {
        return $this;
    }
    public function getHooks() {
        return $this->hooks;
    }
    public function getHooksByName(string $name = '') {
        return $this->hooks[$name] ?? null;
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

        return $this;

    }
    public function run($name, $datas = null) {

        $hooks = $this->getHooksByName($name);

        if($hooks != null && count($hooks) > 0) {
            foreach ($hooks as $hook) {
                # code...
                $object = app($hook);
                $r = call_user_func_array(array($object, 'handle'), array($name ,$datas));
            }
        }

        return $this;
    }
    public function emit(...$args) {}
    public function on(...$args) {}
    public function exec($name, $datas = null) {
        $ret = null;

        $hooks = $this->getHooksByName($name);

        if(!empty($hooks) && is_string($hooks)) {
            $object = app($hooks);
            $ret = call_user_func_array(array($object, 'handle'), array($name ,$datas));
        }

        if(!empty($hooks) && is_array($hooks) && count($hooks) > 0) {
            $ret = '';
            foreach ($hooks as $hook) {
                # code...
                $object = app($hook);
                $ret .= call_user_func_array(array($object, 'handle'), array($name ,$datas));
            }
        }

        return $ret;
    }
    public function registerHooks($name, $arrayClass) {

        foreach ($arrayClass as $class) {
            # code...
            $this->registerHook($name, $class);
        }

        return $this;
    }
}
