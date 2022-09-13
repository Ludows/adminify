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
   public static function createRevisionState($model) {
        $model->createRevision($model->getAttributes());
   }
   public static function updateRevisionState($model) {
        $model->updateRevision($model->getAttributes());
   }
   public static function deleteRevisionState($model) {
     $model->deleteRevisions();
   }
   public static function manageRevisionsState($model) {
     $model->manageRevisions();
   }
   public static function flushCache($model) {

        $builder = $model::query();
        $cachable_keys_storage = $builder->getInCache('cachable_keys_storage');
        $_generated_views_keys = empty($builder->getInCache('_generated_views_keys')) ? [] : $builder->getInCache('_generated_views_keys');

        if(!empty($cachable_keys_storage)) {
            $cachable_keys_storage = json_decode($cachable_keys_storage);
            foreach ($cachable_keys_storage as $key => $value) {
                # code...
                $builder->forgetInCache($value);
            }
        }

        if(!empty($_generated_views_keys)) {
            $arr_caches_views = explode(',',$_generated_views_keys);
            foreach ($arr_caches_views as $key => $value) {
                # code...
                $builder->forgetInCache($value);
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
            static::flushCache($model);
        });

        static::created(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(static::$loadHooks, 'created');
            static::runHook('created', $model);
            if($model->enable_revisions && $model->revisions_limit > 0) {
                static::createRevisionState($model);
                static::manageRevisionsState($model);
            }
        });

        static::updating(function ($model) {
            // bleh bleh
            static::autoRegisterModelHooks(static::$loadHooks, 'updating');
            static::runHook('updating', $model);
            static::flushCache($model);
        });

        static::updated(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(static::$loadHooks, 'updated');
            static::runHook('updated', $model);
            if($model->enable_revisions && $model->revisions_limit > 0) {
                static::updateRevisionState($model);
                static::manageRevisionsState($model);
            }
        });

        static::saving(function ($model) {
            // blah blah
            static::autoRegisterModelHooks(static::$loadHooks, 'saving');
            static::runHook('saving', $model);
            static::flushCache($model);
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
            static::flushCache($model);
            if($model->enable_revisions && $model->revisions_limit > 0) {
                static::deleteRevisionState($model);
            }
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
