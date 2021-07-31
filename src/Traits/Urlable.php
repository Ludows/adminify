<?php

  namespace Ludows\Adminify\Traits;

  use App\Models\Url;
  use Illuminate\Support\Facades\Crypt;
  trait Urlable
  {
     // tell which column to show for your url part
     public $urlableColumn = 'slug';

     public function makeUrl($a = [], $loadConfig = false) {

          if($loadConfig) {
               $defaults = $this->getConfigUrl($a);
          }
          else {
               $defaults = $a;
          }

          $u = new Url();
          foreach ($defaults as $key => $value) {
               # code...
               $u->{$key} = $value;
          }
          $u->save();

          return $u;
     }
     public function encryptToCache($key = '', $values = []) {

          if($key == '') {
               return false;
          }

          $reflect = new \ReflectionClass($this);

          $defaults = [
               'status_id' => $this->status_id,
               'model' => $reflect->name,
               'model_id' => $this->id,
               'parent_id' => $this->parent_id
          ];

          cache([$key => array_merge($defaults, $values)]);
     }

     public function forgetToCache($key = '') {
          forget_cache($key);
     }

     public function updateUrl($a = [], $loadConfig = false) {
          if($loadConfig) {
               $defaults = $this->getConfigUrl($a);
          }
          else {
               $defaults = $a;
          }

          $u = new Url();
          $m = $u->where('from_model_id', $defaults['from_model_id'])->get()->all();

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
          $m = $u->where('from_model_id', $defaults['from_model_id'])->get()->all();

          foreach ($m as $entity) {
               # code...
               $entity->delete();
          }

     }
     public function getConfigUrl($a = []) {

          $reflect = new \ReflectionClass($this);

          $defaults = [
               'from_model' => $reflect->name,
               'from_model_id' => $this->id,
               'model_id' => $this->id,
               'model_name' => $reflect->name,
               'order' => 0
          ];

          return array_merge($defaults, $a);
     }
     public function syncUrl($a = []) {

          $defaults = $this->getConfigUrl($a);

          $u = new Url();
          $check = $u->where([
               ['from_model_id', '=', $defaults['from_model_id']],
               ['from_model', '=', $defaults['from_model']],
               ['model_id', '=', $defaults['model_id']],
               ['model_name', '=', $defaults['model_name']],
               ['order', '=', $defaults['order']],
          ])->get()->all();
          if($check == null) {
               $this->makeUrl($defaults ?? [], false);
          }
          else {
               $this->updateUrl($defaults ?? [], false);
          }

     }
    //  public function walk() {
    //     $a = [];
    //     $context = $this;
    //     $parts = $this->crawlUrlPart($context->parent, $a);
    //     $a = array_merge($a,$parts);
    //     return $a;
    // }
    // public function crawlUrlPart($context, $array = []) {
    //     // if(isset($context)) {
    //         $array[] = $context;
    //         $parent = $context->parent;
    //         $data = is_class($parent) && $parent != 0 ? $parent : $context;

    //         $this->crawlUrlPart($data, $array);
    //     // }
    //     return $array;
    // }
     public function url() {

          $u = new Url();

          $u = $u->where([
            ['from_model_id', '=', $this->id]
          ]);

          $u = $u->orderBy('order');

          return $u->get()->all();
     }
     public function getUrlAttribute() {
          $a = [];

          $collection =  $this->url();
          //dump($collection);
          if(count($collection) > 0) {
               foreach ($collection as $col) {
                    # code...
                    $m = new $col->model_name;
                    $m = $m->where([
                        ['id', '=', $col->model_id]
                    ])->get()->first();

                    $a[] = $m->{$this->urlableColumn};
               }
          }

          return $a;
     }
     public function getUrlPathAttribute() {
        $parts = $this->url;
        return count($parts) > 0 ? url( join('/', $parts) ) : null;
     }
  }
