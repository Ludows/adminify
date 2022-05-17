<?php

  namespace Ludows\Adminify\Traits;

  trait Hookable
  {
   public $loadHooks = [];
   public function runHook($hookName) {

   }
   public function runHooks($arrayOfHooks) {
       
   }
   public static function boot()
    {
        static::creating(function ($model) {
            // blah blah
        });

        static::created(function ($model) {
            // blah blah
        });

        static::updating(function ($model) {
            // bleh bleh
        });

        static::updated(function ($model) {
            // blah blah
        });

        static::saving(function ($model) {
            // blah blah
        });

        static::saved(function ($model) {
            // blah blah
        });
        
        static::deleting(function ($model) {
            // bluh bluh
        });

        static::retrieved(function ($model) {
            // bluh bluh
        });
        
        parent::boot();
    }
  }
