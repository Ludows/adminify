<?php

  namespace Ludows\Adminify\Traits;

  trait Sitemapable
  {
     // tell which column to show for your url part
     public $allowSitemap = true;
     public $sitemapTitle = 'title';
     public $sitemapCallable = null;
  }
