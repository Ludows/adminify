<?php
namespace Ludows\Adminify\Facades;
use Illuminate\Support\Facades\Facade;
class MenuBuilderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'menu-builder';
    }
}
