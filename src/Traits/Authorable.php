<?php

namespace Ludows\Adminify\Traits;


trait Authorable
  {
   //
   public $authorable_column = 'name';
   public function author() {
    return $this->belongsTo(User::class,'user_id', 'id');
   }
  }
