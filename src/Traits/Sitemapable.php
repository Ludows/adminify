<?php

  namespace Ludows\Adminify\Traits;

  trait Sitemapable
  {
     // tell which column to show for your url part
   //   public $sitemapTitle = 'title';
   //   public $sitemapCallable = null;
     public function getsitemapTitleProperty() {
         return isset($this->sitemapTitle) ?
         $this->sitemapTitle:
         'title';
     }
     public function getsitemapCallableProperty() {
      return isset($this->sitemapCallable) ?
      $this->sitemapCallable:
      null;
  }
  }
