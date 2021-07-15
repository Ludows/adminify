<?php

  namespace Ludows\Adminify\Traits;

  use App\Models\Url;
  trait Urlable
  {
     // tell which column to show for your url part
     public $urlableColumn = 'title';

     public function makeUrl() {
          // define as getter and setter
          $u = new Url();
          $u->model_name = $this->getNameSpace();
          $u->model_id = $this->id;
          $u->save();

          return $u;
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
