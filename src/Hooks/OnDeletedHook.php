<?php

namespace Ludows\Adminify\Hooks;

use Ludows\Adminify\Libs\HookInterface;
use Illuminate\Support\Facades\Artisan;

class OnDeletedHook extends HookInterface {
    public function handle($hookName,$datas = null) {
        //data is the model passed

        Artisan::call('adminify:container', []);
    }
}