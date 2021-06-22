<?php

namespace Ludows\Adminify\Traits;
  //
  trait PathableMedia
  {
   public function getFullPath($image = '') {
        $lmf = app("\UniSharp\LaravelFilemanager\LfmPath");
        return $lmf->url($image);
   }
  }
