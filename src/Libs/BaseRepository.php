<?php

namespace Ludows\Adminify\Libs;
use Ludows\Adminify\Libs\Dropdown;

class BaseRepository
{
   protected $model;

   public function _construct() {
    $this->model = null;
   }
}
