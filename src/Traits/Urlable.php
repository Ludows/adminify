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
          $u->model_id = $defaults['id'];
          $u->save();

          return $u;
     }
     public function deleteUrl($a = [], $loadConfig = false) {

          if($loadConfig) {
               $defaults = $this->getConfigUrl($a);
          }
          else {
               $defaults = $a;
          }

          $u = new Url();
          $m = $u->find($defaults['id']);
          $m->delete();
     }
     public function getConfigUrl($a = []) {
          $defaults = [
               'id' => $this->id,
               'namespace' => $this->getNameSpace(),
               'order' => 0
          ];

          return array_merge($defaults, $a);
     }
     public function syncUrl($a = []) {

          $defaults = $this->getConfigUrl($a);

          $u = new Url();
          $check = $u->where('model_id', $defaults['id'])->all();
          if($check == null) {
               $this->makeUrl($defaults['id'] ?? null, $defaults['namespace'] ?? null);
          }

     }
     public function url() {
          $u = new Url();
          return $u->where('model_id', $this->id);
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
