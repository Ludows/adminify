<?php

  namespace Ludows\Adminify\Traits;

  use App\Adminify\Models\Meta;

  trait HasTagsRelations
  {
    public $prefix_meta_tag = '_tags';
    public function generateMetaTagKey($key) {

        $baseClass = get_class($this);
        $baseName = class_basename($baseClass);
  
        return $this->prefix_meta_tag.'_'. lowercase($baseName).'_'.$key;
    }
    public function hasTags($key) {
        $tags = Meta::where(['key' => $this->generateMetaTagKey($key)]);
        return $tags->exists() == true;
    }
    public function getTags($key) {
        $key = $this->generateMetaTagKey($key);
        return $this->getMeta($key);
    }
    public function setTags($key, $datas = []) {
        $key = $this->generateMetaTagKey($key);
        return $this->updateMeta($key, $datas);
    }
    public function updateTags($key, $datas = []) {
        $key = $this->generateMetaTagKey($key);
        return $this->updateMeta($key, $datas);
    }
    public function deleteTags($key) {
        $key = $this->generateMetaTagKey($key);
        return $this->deleteMeta($key);
    }
  }