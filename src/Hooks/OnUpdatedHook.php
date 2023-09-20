<?php

namespace Ludows\Adminify\Hooks;

use Ludows\Adminify\Libs\HookInterface;
use Illuminate\Support\Facades\Artisan;

class OnUpdatedHook extends HookInterface {
    public function handle($hookName,$datas = null) {
        //data is the model passed

        $isEmptyContainer = empty( adminify_autoload() );
        if( $isEmptyContainer ) {
            Artisan::call('adminify:container', []);
        }
    }
}