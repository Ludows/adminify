<?php

namespace Ludows\Adminify\Traits;

use Exception;

trait QueryCachable
{
    protected $useCache = true; // for disable entierly the cache system.
    protected $invalidateOnUpdate = true;
    protected $usePlainKeys = false;
    protected $cacheTime = 3600;
    protected $cacheDriver;
    protected $cachePrefix = 'adminify';
    protected $saveCustomAttributes = [];

    // public function __construct() {
    //     parent::__construct();
    //     dd($this);
    // }

    public function dontCache($value = true) {
        $this->useCache = $value;
        return $this;
    }
    public function setCacheTime($time = 3600) {
        $this->cacheTime = $time;
        return $this;
    }
    public function getCachePrefix() {
        return $this->cachePrefix;
    }
    public function setCachePrefix($value = 'adminify') {
        $this->cachePrefix = $value;
        return $this;
    }
    public function shouldUseCache() {

        if(!method_exists($this, 'defineCacheStrategy') && $this->useCache == true) {
            throw new Exception('you must have defineCacheStrategy in your model :'. get_class($this));
        }
        if(method_exists($this, 'defineCacheStrategy') && $this->useCache == true) {
            return $this->defineCacheStrategy();
        }

        return $this->useCache;
    }
    public function shouldUsePlainKeys() {

        if(!method_exists($this, 'defineKeysStrategy') && $this->usePlainKeys == true) {
            throw new Exception('you must have defineKeysStrategy in your model :'. get_class($this));
        }
        if(!method_exists($this, 'plainKeyPattern') && $this->usePlainKeys == true) {
            throw new Exception('you must have plainKeyPattern in your model :'. get_class($this));
        }
        if(method_exists($this, 'defineKeysStrategy') && $this->usePlainKeys == true) {
            return $this->defineKeysStrategy();
        }

        return $this->usePlainKeys;
    }
}
