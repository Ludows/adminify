<?php

namespace Ludows\Adminify\Traits;

use Ludows\Adminify\Models\Asset;
use Illuminate\Support\Facades\Storage;
  //
  trait ProcessableAssets
  {
    public function hasFile() {
        $editorGlobalConfig = get_site_key('editor');
        $disk = Storage::disk($editorGlobalConfig['diskForSave']);
        $named = lowercase( class_basename($this) ).'-'.$this->id.'.'.$this->type;
        return $disk->exists( $named );
    }
    public function asset() {
        return new Asset();
    }
    public function assets()
    {
       return $this->belongsToMany(Asset::class);
    }
  }
