<?php

  namespace Ludows\Adminify\Traits;

  trait HasThumbs
  {
   protected $thumbs_key = '_thumbs';
   public function getThumbKey() {
    return $this->thumbs_key;
   }
   public function setThumbKey($name = '') {
     $this->thumbs_key = $name;
     return $this;
   }
   public function getThumbsAttribute() {
     $thumbs = $this->getMeta($this->thumbs_key);
     if(!empty($thumbs)) {
        return $thumbs;
     }
     return [];
   }
   public function setThumbs($array = []) {
    $this->updateMeta( $this->thumbs_key, $array);
   }
   public function deleteThumb($thumbSize = '') {
    
    $thumbs = $this->getMeta($this->thumbs_key);
    
    if(!empty($thumbs[$thumbSize]) ) {
        unset( $thumbs[$thumbSize] );
        $this->updateMeta( $this->thumbs_key, $thumbs);
    }
    // $this->updateMeta( $this->thumbs_key, $array);
    // $this->deleteMeta( $this->thumbs_key );
   }
   public function deleteThumbs() {
    $this->deleteMeta( $this->thumbs_key );
   }
  }
