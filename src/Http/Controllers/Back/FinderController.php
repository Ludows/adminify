<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Ludows\Adminify\Libs\SitemapRender;

class FinderController extends Controller
{
    public function index(Request $request) {

        $resource = Str::title($request->type);
        $resoucable = adminify_get_class( singular($resource), ['app:models', 'app:adminify:models'], false);
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
                $m = $m->where($key.'->'.$lang, $value);
            }
            else {
                $m = $m->where($key, $value);
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
