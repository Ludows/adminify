<?php

class Theme {
    public function __construct() {}
    public function handle() {
        $themeManager = $this->manager;
        $request = $this->request;
        $parameters = $this->params;
        $multiBasic = $this->middleware;
    }
}
