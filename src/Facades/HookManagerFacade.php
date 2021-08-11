<?php
namespace Ludows\Adminify\Facades;
use Illuminate\Support\Facades\Facade;

class HookManagerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'HookManager';
    }
}
