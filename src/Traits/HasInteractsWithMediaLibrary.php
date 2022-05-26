<?php

namespace Ludows\Adminify\Traits;
use App\Adminify\Models\Media;
use Ludows\Adminify\Libs\MediaService;

trait HasInteractsWithMediaLibrary
  {
    public $media_key = 'media_id';
    public function getFullPath($image = '') {
         $service = app(MediaService::class);
         return $service->url( !empty($image) ? $image : $this->src );
    }
    public function getRelativePath( $image= '') {
      $service = app(MediaService::class);
      return $service->relativeUrl( !empty($image) ? $image : $this->src );
    }
 
    public function media()
     {
         return $this->belongsTo(Media::class, $this->media_key, 'id');
     }

     public function medias()
     {
        //  return $this->hasMany(Media::class, $this->media_key, 'id');
     }
  }
