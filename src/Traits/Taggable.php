<?php

  namespace Ludows\Adminify\Traits;
  use App\Models\Tag;

  trait Taggable
  {
    public function tags() {
      return $this->hasMany(Tag::class);
    }
  }
