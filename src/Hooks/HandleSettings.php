<?php

namespace Ludows\Adminify\Hooks;

use Ludows\Adminify\Libs\HookInterface;
use Ludows\Adminify\Facades\HookManagerFacade;

use App\Models\Url;

class HandleSettings extends HookInterface {
    public function handle($datas = null) {
        //data is the model passed
        $handles = [
            'homepage' => setting('homepage'),
            'blogpage' => setting('blogpage')
        ];

        $modelHook = $datas;

        if($modelHook != null) {
            $m = null;
            if($modelHook->type == 'homepage') {
                $m = Url::where('from_model', 'App\Models\Page')->where('model_id', (int) $handles['homepage'])->get()->first();
                $key = 'is_homepage';
                $val = $handles['homepage'];
            }
            if($modelHook->type == 'blogpage') {
                $m = Url::where('from_model', 'App\Models\Page')->where('model_id', (int) $handles['blogpage'])->get()->first();
                $key = 'is_blogpage';
                $val = $handles['blogpage'];
            }

            if($m != null) {
                $m->fill([
                    $key => $val
                ]);

                if(is_urlable_model($m)) {
                    HookManagerFacade::run('model:updated', $m);
                }
            }
        }

    }
}