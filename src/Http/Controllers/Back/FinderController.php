<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Libs\SitemapRender;

class FinderController extends Controller
{
    public function index(Request $request) {

        $resource = $request->type;
        $resoucable = get_site_key('register.'.$resource);
        $multi = $request->useMultilang;
        $lang = lang();

        if(!isset($resource) || !isset($resoucable)) {
            abort(403);
        }

        $all = $request->all();
        $m = new $resoucable();

        $iterator = 0;
        foreach ($all as $key => $value) {
            # code...

            if($m->isTranslatableColumn($key) && $multi) {
                $m->where($key.'->'.$lang, $value);
            }
            else {
                $m->where($key, $value);
            }

            $iterator++;
        }

        $m = $m->get();

        $a = [
            'models' => $m,
            'status' => 'OK',
        ];

        return response()->json($a);
    }
}
