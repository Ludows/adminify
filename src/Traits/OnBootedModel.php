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

    protected static function walkThroughtParents($context, $from = null,  $baseOrder = 1) {
        $parentable = $context->parent_id;
        //dump($parentable);
        $reflect = new \ReflectionClass($context);

        if(isset($parentable) && $parentable != 0) {
            $context->syncUrl([
                'from_model_id' => $from,
                'model_id' => $context->id,
                'model_name' => $reflect->name,
                'order' => $baseOrder
            ]);
            //access to parent
            $parent = $context->getParent($parentable);

            static::walkThroughtParents($parent, $from,  $parent->id);
        }
        else {
            // it's the root path of your url
            $context->syncUrl([
                'from_model_id' => $from,
                'model_name' => $reflect->name,
                'order' => 0
            ]);
        }
    }

    protected static function syncronizeUrl($context) {

        // they load a walker to create record in db;
        static::walkThroughtParents($context, $context->id, $context->id);

    }

    protected static function booted()
    {


        static::creating(function ($model) {
            //
            $fillables = $model->getFillable();
            if(in_array('title', $fillables)) {
                static::updateSlug($model);
            }

        });

        static::created(function ($model) {
            if(is_urlable_model($model) && $model->allowSitemap) {
                static::syncronizeUrl($model);
                static::syncToCache($model);
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
        });

        static::updated(function ($model) {
            if(is_urlable_model($model) && $model->allowSitemap) {
                static::syncronizeUrl($model);
                static::syncToCache($model);
            }
            if(is_sitemapable_model($model)) {
                static::loadGenerateSitemap($model);
            }
        });
    }
  }
