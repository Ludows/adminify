<?php

namespace Ludows\Adminify\Traits;


trait HasFeaturedMedia
  {
    public $featured_column_media = 'media_id';
    public function getFeaturedMedia() {
        $ret = null;
        if(!empty($this->{$this->featured_column_media})) {
            $ret = media( $this->{$this->featured_column_media} );
        }

        return $ret;
    }
  }
