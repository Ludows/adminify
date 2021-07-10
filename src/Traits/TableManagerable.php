<?php

  namespace Ludows\Adminify\Traits;

  use Ludows\Adminify\Models\Url;
  trait TableManagerable
  {
   //
   public function table($tableClass) {
        return $tableClass->render();
   }
  }
