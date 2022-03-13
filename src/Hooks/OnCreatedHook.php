<?php

namespace Ludows\Adminify\Hooks;

use Ludows\Adminify\Libs\HookInterface;
use Illuminate\Support\Facades\Artisan;
class OnCreatedHook extends HookInterface {
    public function handle($hookName,$datas = null) {
        //data is the model passed
        $m = $datas;
        if(!empty($m) && $m instanceof \App\Adminify\Models\Translations) {
            Artisan::call('adminify:translations', [

            ]);
        }
    }
}