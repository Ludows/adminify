<?php

  namespace Ludows\Adminify\Traits;

  use Ludows\Adminify\Facades\HookManagerFacade;
  trait Hookable
  {
   public static $loadHooks = [];
   public static function runHook($hookName, $model) {
     $hookManager = HookManagerFacade::getInstance();
     $hookManager->run($hookName,$model);
   }
   public static function runHooks($arrayOfHooks, $model) {
    if(is_array($arrayOfHooks)) {
        foreach ($arrayOfHooks as $hookKey => $hookValue) {
            # code...
            static::runHook($hookKey, $model);
        }
    }
   }
   public static function autoRegisterModelHooks($arrayOfHooks = [], $hookName) {
        $hookManager = HookManagerFacade::getInstance();
        if(!empty($arrayOfHooks[$hookName]) && !$hookManager->exist($hookName)) {

            if(is_array($arrayOfHooks[$hookName])) {
                foreach ($arrayOfHooks[$hookName] as $key => $value) {
                    # code...
                    $hookManager->registerHook($hookName, $value);
                }
            }
            else {
                $hookManager->registerHook($hookName, $arrayOfHooks[$hookName]);
            }

        }
   }
   public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(static::$loadHooks, 'creating');
            static::runHook('creating', $model);
        });

        static::created(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(static::$loadHooks, 'created');
            static::runHook('created', $model);
        });

        static::updating(function ($model) {
            // bleh bleh
            static::autoRegisterModelHooks(static::$loadHooks, 'updating');
            static::runHook('updating', $model);
        });

        static::updated(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(static::$loadHooks, 'updated');
            static::runHook('updated', $model);
        });

        static::saving(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(static::$loadHooks, 'saving');
            static::runHook('saving', $model);
        });

        static::saved(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(static::$loadHooks, 'saved');
            static::runHook('saved', $model);
        });

        static::deleting(function ($model) {
            // bluh bluh
            static::autoRegisterModelHooks(static::$loadHooks, 'deleting');
            static::runHook('deleting', $model);
        });

        static::deleted(function ($model) {
            // bluh bluh
            static::autoRegisterModelHooks(static::$loadHooks, 'deleted');
            static::runHook('deleted', $model);
        });

        static::retrieved(function ($model) {
            // bluh bluh
            static::autoRegisterModelHooks(static::$loadHooks, 'retrieved');
            static::runHook('retrieved', $model);
        });

    }
  }
