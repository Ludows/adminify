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
  }
