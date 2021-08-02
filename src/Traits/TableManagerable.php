<?php

  namespace Ludows\Adminify\Traits;

  use Ludows\Adminify\Models\Url;
  trait TableManagerable
  {
   //
   public function table($tableClass, $options = []) {

        $c = new $tableClass();
        $c->options($options);

        return $c;
   }
  }
