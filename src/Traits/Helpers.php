<?php

  namespace Ludows\Adminify\Traits;

  trait Helpers
  {
   //
   public function getNameSpace()
    {
        return __CLASS__; //  returns App\Models\Post;
    }
    public function isMultiLangModel() {
        return method_exists($this, 'getNeededTranslations');
    }
  }
