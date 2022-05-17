<?php

namespace Ludows\Adminify\Traits;
use App\Adminify\Models\Media;
  //
  trait PathableMedia
  {
   public $media_key = 'media_id';
   public function getFullPath($image = '') {
        $lmf = app("\UniSharp\LaravelFilemanager\LfmPath");
        return $lmf->url( !empty($image) ? $image : $this->src );
   }

   public function media()
    {
        return $this->belongsTo(Media::class, $this->media_key, 'id');
    }
  }
