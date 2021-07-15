<?php

  namespace Ludows\Adminify\Traits;

  use App\Models\Url;
  trait Urlable
  {
     // tell which column to show for your url part
     public $urlableColumn = 'title';

     public function makeUrl($a = [], $loadConfig = false) {
          
          if($loadConfig) {
               $defaults = $this->getConfigUrl($a);
          }
          else {
               $defaults = $a;
          }

          $u = new Url();
          $u->model_name = $defaults['namespace'];
          $u->model_id = $defaults['model_id'];
          $u->save();

          return $u;
     }
     public function updateUrl($a = [], $loadConfig = false) {
          if($loadConfig) {
               $defaults = $this->getConfigUrl($a);
          }
          else {
               $defaults = $a;
          }
          
          $u = new Url();
          $m = $u->where('from_model_id', $defaults['from_model_id']);
          
          foreach ($m as $entity) {
               # code...
               $entity->fill($defaults);
          }

          return $m;
     }
     public function deleteUrl($a = [], $loadConfig = false) {

          if($loadConfig) {
               $defaults = $this->getConfigUrl($a);
          }
          else {
               $defaults = $a;
          }

          $u = new Url();
          $m = $u->where('from_model_id', $defaults['from_model_id']);
          
          foreach ($m as $entity) {
               # code...
               $entity->delete();
          }
          
     }
     public function getConfigUrl($a = []) {
          $defaults = [
               'from_model' => $this->getNameSpace(),
               'from_model_id' => $this->id,
               'model_id' => $this->id,
               'model_name' => $this->getNameSpace(),
               'order' => 0
          ];

          return array_merge($defaults, $a);
     }
     public function syncUrl($a = []) {

          $defaults = $this->getConfigUrl($a);

          $u = new Url();
          $check = $u->where('from_model_id', $defaults['from_model_id'])->all();
          if($check == null) {
               $this->makeUrl($defaults ?? [], false);
          }
          else {
               $this->updateUrl($defaults ?? [], false);
          }

     }
     public function url() {
          $u = new Url();
          return $u->where('from_model_id', $this->id)->all();
     }
     public function urlAttribute() {
          $a = [];

          $collection =  $this->url();
          if($collection != null) {
               foreach ($collection as $col) {
                    # code...
                    $str_model = $col->model_name;
                    $m = new $str_model();
                    $a[] = $m->{$this->urlableColumn};
               }
          }

          return $a;
     }
  }
