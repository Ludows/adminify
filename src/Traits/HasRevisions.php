<?php

  namespace Ludows\Adminify\Traits;

  trait HasRevisions
  {
   //
   public $enable_revisions = true;
   public $revisions_limit = -1;
   public function shouldUseRevisions() {}
  }
