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
        $context->encryptToCache($context->id);
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
                static::syncToCache($model);
            }
        });
    }
  }
