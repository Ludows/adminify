<?php

namespace Ludows\Adminify\Libs;

use Exception;

class ThemeManager
{
    public function __construct()
    {
        $this->locations = [];
        $this->request = request();
    }
    public function script() {}
    public function style() {}
    public function styles($array = []) {}
    public function scripts($array = []) {}
    public function registerLocations($array = []) {}
    public function handle() {}
    public function infos() {}
    public function resolve() {}
}