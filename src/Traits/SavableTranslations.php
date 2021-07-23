<?php

namespace Ludows\Adminify\Traits;
  //
  trait SavableTranslations
  {
   public $excludes_savables_fields = [];
   public $unmodified_savables_fields = [];
   public function getSavableForm() {}
  }
