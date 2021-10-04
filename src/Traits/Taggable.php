<?php

  namespace Ludows\Adminify\Traits;
  use App\Adminify\Models\Tag;

  trait Taggable
  {
    public function tags() {
      return $this->belongsToMany(Tag::class);
    }
    public function createTags($array) {
        $this->tags()->attach($array);
        return $this;
    }
    public function createTag($id) {
      $this->tags()->attach($id);
      return $this;
    }
    public function updateTags($array) {
      $this->tags()->syncWithoutDetaching($array);
      return $this;
    }
    public function deleteTags($array) {
      if(is_null($array)) {
        $this->tags()->detach();
      }
      else {
        $this->tags()->detach($array);
      }
      return $this;
    }
    public function deleteTag($id) {
      $this->tags()->detach($id);
      return $this;
    }
  }
