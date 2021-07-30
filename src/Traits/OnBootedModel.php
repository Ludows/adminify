<?php
  namespace Ludows\Adminify\Traits;
  use Illuminate\Support\Str;

  use Ludows\Adminify\Libs\SitemapRender;

  trait OnBootedModel
  {
   //
    protected static function updateSlug($context) {
        $context->slug = Str::slug($context->title, '-');

    }

    protected static function loadGenerateSitemap($context) {
        $s = app()->make('Ludows\Adminify\Libs\SitemapRender');
        $s->setOptions([
            'models' => [$context->getTable() => 'register.'.$context->getTable()],
            'modelName' => $context->getTable(),
            'writeFile' => true,
        ]);
        $s->render();
    }

    protected static function syncToCache($context) {
        $url = $context->url;
        if($url != null) {
            $context->encryptToCache(join('.', $url));
        }
    }

    protected static function syncronizeUrl($context) {

        if(isset($context->parent_id) && $context->parent_id != 0) {
            $reflect = new \ReflectionClass($context);

            $context->syncUrl([
                'model_id' => $context->parent_id,
                'model_name' => $reflect->name,
                'order' => 0
            ]);
        }

        $context->syncUrl([
            'order' => 1
        ]);
    }

    protected static function booted()
    {
        
        
        static::creating(function ($model) {
            //
            $fillables = $model->getFillable();
            if(in_array('title', $fillables)) {
                static::updateSlug($model);
            }

            if(is_sitemapable_model($model)) {
                static::loadGenerateSitemap($model);
            }

            if(is_urlable_model($model)) {
                static::syncronizeUrl($model);
                static::syncToCache($model);
            }
            
        });
        static::updating(function ($model) {
            //
            $fillables = $model->getFillable();
            if(in_array('title', $fillables)) {
                static::updateSlug($model);
            }
            
            if(is_sitemapable_model($model)) {
                static::loadGenerateSitemap($model);
            }

            if(is_urlable_model($model)) {
                static::syncronizeUrl($model);
                static::syncToCache($model);
            }
        });
    }
  }
