<?php

  namespace Ludows\Adminify\Traits;

  trait HasUser
  {
  
   public $userModel = \App\Adminify\Models\User::class;
   public $userRelationNameType = 'hasOne';
   public $userForeignKey = 'id';
   public $userOwnerKey = 'user_id';
   public function user() {
    return $this->{$this->userRelationNameType}($this->userModel, $this->userForeignKey, $this->userOwnerKey);
   }
   public function getUserAttribute() {
    $m = new $this->userModel;
    $m->where('id', $this->{$this->userForeignKey});
    return $m->first();
   }
  }
