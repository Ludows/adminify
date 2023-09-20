<?php

namespace Ludows\Adminify\Libs;

use Exception;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use Illuminate\Support\Arr;

class QueryCachableModule extends BaseBuilder {


    public function __construct($query) {
        parent::__construct($query);
        $this->cacheDriver = config('cache.default');
    }
    public function get($columns = ['*'])
    {
        return  !$this->model->shouldUseCache()
            ? parent::get($columns)
            : $this->getQueryCache('get', Arr::wrap($columns),  Arr::collapse([$this->getBindings() , []]));
    }
    public function find($id, $columns = ['*'])
    {
        return  !$this->model->shouldUseCache()
            ? parent::find($id, $columns)
            : $this->getQueryCache('find', Arr::wrap($columns),  Arr::collapse([$this->getBindings() , ['id' => $id]]));
    }
    public function setCacheDriver($driver) {
        $this->cacheDriver = $driver;
        return $this;
    }
    public function getCacheDriver() {
        $cacheSystem = $this->getCacheSystem();
        return $cacheSystem->driver($this->cacheDriver);
    }
    public function getCacheSystem() {
        return app('cache');
    }
    public function handleKeys($method = 'get', $columns = ['*'], $appends = null) {
        $useOfPlainKeys = $this->model->shouldUsePlainKeys();
        if($useOfPlainKeys) {
            return $this->model->plainKeyPattern($method, $columns, $appends);
        }
        else {
            return $this->generateKeyCache($method, $columns, $appends);
        }
    }
    public function remember($cacheKey, $closure = null) {
        $time = $this->model->cacheTime;
        if(is_null($closure)) {
            throw new Exception('remember needs a callback as a closure in '.get_class($this));
        }
        return $this->getCacheSystem()->remember($cacheKey, $time, $closure);
    }
    public function rememberForever($cacheKey, $closure = null) {
        if(is_null($closure)) {
            throw new Exception('rememberForever needs a callback as a closure in '.get_class($this));
        }
        return $this->getCacheSystem()->rememberForever($cacheKey, $closure);
    }
    public function generateKeyCache($method = 'get', $columns = ['*'], $appends = null) {
        $table = $this->model->getTable();
        $isMultilang =  is_multilang();
        $prefix = $this->model->getCachePrefix();
        $columns = join('.',$columns);
        // let's build the key cache :)

        if(!is_null($appends)) {
            $appends = $this->renderBindingsAsString($appends);
        }

        $generatedKeyCache = $prefix.'.'.$method.'.'.$table.'.'.$appends.'.'.$columns;
        if($isMultilang) {
            $lang = $this->model->getLocale();
            $generatedKeyCache = $prefix.'.'.$method.'.'.$lang.'.'.$table.'.'.$appends.'.'.$columns;
        }

        return $generatedKeyCache;
    }
    public function existsInCache($key) {
        return $this->getCacheSystem()->has($key);
    }
    public function setInCache($cacheKey, $value) {
        $cache = $this->getCacheSystem();
        $time = $this->model->cacheTime;
        if($time != -1) {
            $cache->put($cacheKey, $value);
        }
        else {
            $cache->put($cacheKey, $value, $time);
        }
        return $this;
    }
    public function getInCache($cacheKey) {
        return $this->getCacheSystem()->get($cacheKey);
    }
    public function forgetInCache($cacheKey) {
        $this->getCacheSystem()->forget($cacheKey);
        return $this;
    }
    public function renderBindingsAsString($appends = []) {
        $formatString = [];
        if(is_array($appends)) {
            foreach ($appends as $key => $value) {
                # code...
                $formatString[] = $key.'-'.$value;
            }

            return join('-', $formatString);
        }

        return $appends;
    }
    public function getQueryCache($method = 'get', $columns = ['*'], $appends = []) {
        // if present cache, return the query
        $key = $this->handleKeys($method, $columns, $appends);
        $exist = $this->existsInCache($key);
        $keys_store = $this->getInCache('cachable_keys_storage');

        if(empty($keys_store)) {
            $this->setInCache('cachable_keys_storage', json_encode([]));
        }

        if(!empty($keys_store)) {
            $keys_store = json_decode($keys_store);

            if(!in_array($key, $keys_store)) {
                $keys_store[] = $key;
                $this->setInCache('cachable_keys_storage', json_encode($keys_store));
            }

        }

        if($exist) {
            return $this->getInCache($key);
        }
        else {
            // we fetch for you and set it to the cache.
            // we test in bindings we retrieve id queried;
            if($appends && !empty($appends['id'])) {
                $queried = parent::{$method}($appends['id'], $columns);
            }
            else {
                $queried = parent::{$method}($columns);
            }

            $this->setInCache($key, $queried);
        }

        return $exist ? $this->getInCache($key) : $queried;

        // otherwhise fallback to the query

    }
}
