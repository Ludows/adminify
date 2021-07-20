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
        $s = SitemapRender();
        $s->setOptions([
            'models' => [$context->getTableName() => 'register.'.$context->getTableName()],
            'modelName' => $context->getTableName(),
            'writeFile' => true,
        ]);
        $s->render();
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
        });
    }
  }
