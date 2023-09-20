<?php
namespace Ludows\Adminify\Facades;
use Illuminate\Support\Facades\Facade;
class ThemeManagerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ThemeManager';
    }
}
