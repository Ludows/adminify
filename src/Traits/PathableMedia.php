<?php

namespace Ludows\Adminify\Traits;
use App\Adminify\Models\Media;
  //
  trait PathableMedia
  {
   public function getFullPath($image = '') {
        $lmf = app("\UniSharp\LaravelFilemanager\LfmPath");
        return $lmf->url( !empty($image) ? $image : $this->src );
   }

   public function media()
    {
        return $this->belongsTo(Media::class,'media_id', 'id');
    }
  }
