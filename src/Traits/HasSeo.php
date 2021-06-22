<?php

namespace Ludows\Adminify\Traits;

  use Ludows\Adminify\Models\Seo;

  trait HasSeo
  {
   //
   public function seo() {
       return $this->hasMany(Seo::class, 'model_id', 'id');
   }
   public function seoWith($type, $object = true) {
       $s = new Seo();

       $q = $s->type($type)->modelId($this->id)->modelName($this->getNameSpace());

       $test =  $q->first();
       if($test != null) {
            $r = $test;
            if($object == false) {
                $r = $r->data;
            }
       }
       return $test != null ? $r : null;
   }

  }
