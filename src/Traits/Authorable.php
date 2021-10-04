<?php

namespace Ludows\Adminify\Traits;
use App\Adminify\Models\User;


trait Authorable
  {
   //
   public $authorable_column = 'name';
   public function author() {
    return $this->belongsTo(User::class,'user_id', 'id');
   }
  }
