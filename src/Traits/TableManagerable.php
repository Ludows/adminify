<?php

  namespace Ludows\Adminify\Traits;

  use App\Adminify\Models\Url;
  trait TableManagerable
  {
   //
   public function table($tableClass, $options = []) {

        $c = new $tableClass();
        $c = $c->options($options);

        return $c;
   }
  }
