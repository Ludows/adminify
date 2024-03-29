<?php

  namespace Ludows\Adminify\Traits;

  use App\Adminify\Models\Meta;

  trait HasCategoriesRelations
  {
    public $prefix_meta_category = '_categories';
    public function generateMetaCategoryKey($key) {

        $baseClass = get_class($this);
        $baseName = class_basename($baseClass);
  
        return $this->prefix_meta_category.'_'. lowercase($baseName).'_'.$key;
    }
    public function hasCategories($key) {
        $cats = Meta::where(['key' => $this->generateMetaCategoryKey($key)]);
        return $cats->exists() == true;
    }
    public function getCategories($key) {
        $key = $this->generateMetaCategoryKey($key);
        return $this->getMeta($key);
    }
    public function setCategories($key, $datas = []) {
        $key = $this->generateMetaCategoryKey($key);
        return $this->updateMeta($key, $datas);
    }
    public function updateCategories($key, $datas = []) {
        $key = $this->generateMetaCategoryKey($key);
        return $this->updateMeta($key, $datas);
    }
    public function deleteCategories($key) {
        $key = $this->generateMetaCategoryKey($key);
        return $this->deleteMeta($key);
    }
  }