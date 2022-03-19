<?php

  namespace Ludows\Adminify\Traits;

  trait SimpleCacheModel
  {
     public $cache_time = 3600;
     // tell which column to show for your url part
     public static function boot() {
        parent::boot();
     }
     public function remember($time = null, $customQuery = null) {
        
        $hasTime = !empty($time);
        $hasCustomQuery = !empty($customQuery);
        $cache = cache();
        $cacheKey =  $this->getCacheKey();

        if($hasTime) {
            $cache->remember($cacheKey, $hasTime ? $time : $this->$cache_time, $hasCustomQuery ? $customQuery : function() { return $this; });
        }
        else {
           $cache->rememberForever($cacheKey , $hasCustomQuery ? $customQuery : function() { return $this; });
        }

        return $this;
     }
     public function getCacheKey() {
        return sprintf(
            "%s/%s",
            $this->getTable(),
            $this->getKey(),
        );
     }
    
  }
