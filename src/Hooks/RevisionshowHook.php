<?php

namespace App\Hooks;

use Ludows\Adminify\Libs\HookInterface;

class RevisionShowHook extends HookInterface
{
    public function __construct() {}
    public function handle($hookName, $datas = null) {
        $r = request();
        $v = view();
        if(!is_front() && !$r->isCreate) {
            return $v->make('adminify::components.revisions', [
                'model' => $r->model
            ]);
        }
       return '';
    }
}
