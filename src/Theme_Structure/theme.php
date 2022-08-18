<?php

class Theme {
    public function __construct() {}
    public function handle($themeManager, $request, $parameters) {
        $themeManager = $this->manager;
        $request = $this->request;
        $parameters = $this->params;
    }
}
