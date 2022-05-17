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
        if(!$hookManager->exist($arrayOfHooks[$hookName])) {

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
        static::creating(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(self::$loadHooks, 'creating');
            static::runHook('creating', $model);
        });

        static::created(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(self::$loadHooks, 'created');
            static::runHook('created', $model);
        });

        static::updating(function ($model) {
            // bleh bleh
            static::autoRegisterModelHooks(self::$loadHooks, 'updating');
            static::runHook('updating', $model);
        });

        static::updated(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(self::$loadHooks, 'updated');
            static::runHook('updated', $model);
        });

        static::saving(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(self::$loadHooks, 'saving');
            static::runHook('saving', $model);
        });

        static::saved(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(self::$loadHooks, 'saved');
            static::runHook('saved', $model);
        });
        
        static::deleting(function ($model) {
            // bluh bluh
            static::autoRegisterModelHooks(self::$loadHooks, 'deleting');
            static::runHook('deleting', $model);
        });

        static::deleted(function ($model) {
            // bluh bluh
            static::autoRegisterModelHooks(self::$loadHooks, 'deleted');
            static::runHook('deleted', $model);
        });

        static::retrieved(function ($model) {
            // bluh bluh
            static::autoRegisterModelHooks(self::$loadHooks, 'retrieved');
            static::runHook('retrieved', $model);
        });
        
        parent::boot();
    }
  }
