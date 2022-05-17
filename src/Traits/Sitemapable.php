<?php

  namespace Ludows\Adminify\Traits;

  trait Sitemapable
  {
     // tell which column to show for your url part
     public $allowSitemap = true;
     public $sitemapTitle = 'title';
     public $priority_sitemap = 0.9;
     public $freq_sitemap = 'montly';
     public function getSitemapUrl() {}
     public function getSitemapImages() {
        // can be array of images or a collections of images
        return [];
     }
  }
