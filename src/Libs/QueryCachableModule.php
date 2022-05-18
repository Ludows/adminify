<?php

namespace Ludows\Adminify\Libs;

use Illuminate\Database\Query\Builder as BaseBuilder;

class QueryCachableModule extends BaseBuilder {
    
    public function get($columns = ['*'])
    {
        // dd($columns,)
        // return $this->shouldAvoidCache()
        //     ? parent::get($columns)
        //     : $this->getFromQueryCache('get', Arr::wrap($columns));
    }
}
