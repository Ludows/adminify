<?php

namespace Ludows\Adminify;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ludows\Adminify\Skeleton\SkeletonClass
 */
class AdminifyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'adminify';
    }
}
