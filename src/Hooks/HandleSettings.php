<?php

namespace Ludows\Adminify\Hooks;

use Ludows\Adminify\Libs\HookInterface;

use App\Models\Url;

class HandleSettings extends HookInterface {
    public function handle($datas = null) {
        //data is the model passed
        $handles = [
            'homepage' => setting('homepage'),
            'blogpage' => setting('blogpage')
        ];

        foreach ($handles as $key => $value) {
            # code...
            if(!is_null($value)) {

                $m = Url::where('from_model', 'App\Models\Page')->where('model_id', (int) $value)->get()->first();

                if($m != null) {
                    $m->fill([
                        'is_'.$key => $value
                    ]);
                }

            }
        }


    }
}