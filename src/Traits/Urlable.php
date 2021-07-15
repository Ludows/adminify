<?php

  namespace Ludows\Adminify\Traits;

  use App\Models\Url;
  trait Urlable
  {
     //
     public function url($model = null) {
          // define as getter and setter
          $u = new Url();
          if(is_null($model)) {
               $u->model_name = $model->getNameSpace();
               $u->model_id = $model->id;
               $u->data = $model->title;
               $u->save();
          }
          else {
               $u->where('model_id', $this->id);
          }

          return $u;
     }
     public function urlAttribute() {
          return $this->url();
     }
  }
