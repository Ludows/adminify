<?php
namespace Ludows\Adminify\Facades;
use Illuminate\Support\Facades\Facade;

class HookFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Hook';
    }
}
