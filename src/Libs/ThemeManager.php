<?php

namespace Ludows\Adminify\Libs;

use Exception;
use File;

class ThemeManager
{
    public function __construct()
    {
        $this->file_config = 'Theme.php';
        $this->request = request();
        $this->view = view();
        $this->config = null;
        $this->wasRequired = false;
    }
    public function assets($array = []) {

        foreach ($array as $key => $value) {
            # code...
            $this->asset('default', $value);
        }
        return $this;
    }
    public function asset($group = 'default', $src = null) {
        \Assets::group($group)->add($src);
        return $this;
    }
    public function getTheme() {
        return theme();
    }
    // public
    public function getFileRoutes($fileRoutes) {
        $theme = $this->checkTheme();

        $theme_path = theme_path(DIRECTORY_SEPARATOR.$theme);
        $file_path = $theme_path.DIRECTORY_SEPARATOR.$fileRoutes.'.php';
        $exist = File::exists($file_path);

        if(!$exist) {
            throw new Exception($fileRoutes.'.php must be provided in your theme. Please to create one.', 500);
        }

        return $file_path;
    }
    public function fireConfig() {
        $config = empty($this->config) ? $this->config() : $this->config;

        if(method_exists($config, 'handle')) {
            $config->handle();
        }
    }
    public function fire($string = '', $mixed) {
        $config = empty($this->config) ? $this->config() : $this->config;

        if(!empty($string) && method_exists($config, 'fire'.$string)) {
            $config->{'fire'.$string}($mixed);
        }
        if(empty($string)) {
            $this->fireConfig();
        }
        return $this;
    }
    public function setToConstructor($class, $array = []) {
        if(empty($class)) {
            throw new Exception('a Class must be specified', 500);
        }

        foreach ($array as $key => $value) {
            # code...
            $class->{$key} = $value;
        }

        $this->config = $class;
        return $this;
    }
    public function global($key, $value) {
        $this->view->share($key, $value);
        $this->request->{$key} = $value;
    }
    private function checkTheme() {
        $theme = $this->getTheme();


        if(empty($theme)) {
            throw new Exception('Theme cannot be resolved', 500);
        }

        return $theme;
    }
    public function config() {

        $theme = $this->checkTheme();

        $theme_path = theme_path(DIRECTORY_SEPARATOR.$theme);
        $file_path = $theme_path.DIRECTORY_SEPARATOR.$this->file_config;
        $exist = File::exists($file_path);

        if(!$exist) {
            throw new Exception($this->file_config.' must be provided in your theme. Please to create one.', 500);
        }

        // prevent recall the Class Theme
        if(class_exists('Theme')) {
            $this->wasRequired = true;
        }

        if($this->wasRequired == false) {
            require_once($file_path);
            $this->wasRequired = true;
        }

        return new \Theme();
    }
}
