<?php

namespace Ludows\Adminify\Libs;

use Exception;
use File;

class ThemeManager
{
    public function __construct()
    {
        $this->locations = [];
        $this->file_config = 'Theme.php';
        $this->request = request();
        $this->view = view();
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

        $require = require($file_path);

        return new \Theme();
    }
}
