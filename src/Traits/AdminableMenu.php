<?php

namespace Ludows\Adminify\Traits;

trait AdminableMenu
  {
    public $showInMenu = true;
    public function getLinks($menuBuilder, $arrayDatas) {}
  }
