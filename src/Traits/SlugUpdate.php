<?php
  namespace Ludows\Adminify\Traits;
  use Illuminate\Support\Str;

  trait SlugUpdate
  {
   //
    protected static function updateSlug($context) {
        $context->slug = Str::slug($context->title, '-');

    }

    protected static function booted()
    {
        static::creating(function ($model) {
            //
            static::updateSlug($model);
        });
        static::updating(function ($model) {
            //
            static::updateSlug($model);
        });
    }
  }
