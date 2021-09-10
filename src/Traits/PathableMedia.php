<?php

namespace Ludows\Adminify\Traits;
use App\Models\Media;
  //
  trait PathableMedia
  {
   public function getFullPath($image = '') {
        $lmf = app("\UniSharp\LaravelFilemanager\LfmPath");
        return $lmf->url($image);
   }

   public function media()
    {
        return $this->belongsTo(Media::class,'media_id', 'id');
    }
  }
