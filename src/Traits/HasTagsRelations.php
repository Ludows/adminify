<?php

  namespace Ludows\Adminify\Traits;

  use App\Adminify\Models\Meta;

  trait HasTagsRelations
  {
    public $prefix_meta_tag = '_tags';
    public $meta_column_key_for_tag = 'id';
    public function generateMetaTagKey($key) {

        $baseClass = get_class($this);
        $baseName = class_basename($baseClass);
  
        return $this->prefix_meta_tag.'_'. lowercase($baseName).'_'.$key;
    }
    public function getTagsAttribute() {
        $tag_ids = $this->getTags( $this->{$this->meta_column_key_for_tag} );
        $tags = model('Tag')->whereIn('id', $tag_ids)->get();
        return $tags;
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