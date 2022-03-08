<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Ludows\Adminify\Libs\SitemapRender;

class FinderController extends Controller
{
    public function contentTypes(Request $request) {

       $models = adminify_get_classes_by_folders(['app:models', 'app:adminify:models']);

       $excludes = get_site_key('metas.excludes');

        foreach ($models as $key => $value) {
            # code...
            if(in_array($key, $excludes)) {
                unset($models[$key]);
            }

        }

       $a = [
        'models' => $models,
        'status' => 'OK',
       ];

       return response()->json($a);

    }
    public function index(Request $request) {

        $resource = Str::title($request->type);
        $resoucable = adminify_get_class( singular($resource), ['app:adminify:models', 'app:models'], false);

        $multi = $request->useMultilang;
        $lang = lang();
        $excludes = [
            '_method',
            '_token',
        ];

        if(!isset($resource) || !isset($resoucable)) {
            abort(403);
        }

        $all = $request->all();
        $m = new $resoucable();

        $labelToShow = $m->searchable_label;

        $iterator = 0;

        foreach ($all as $key => $value) {
            # code...
            if(in_array($key, $excludes)) {
                unset($all[$key]);
            }
        }

        if(count($all) > 0) {
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
        }
        else {
            $m = $m->all();
        }





        $a = [
            'models' => $m,
            'status' => 'OK',
            'labelToShow' => $labelToShow
        ];

        return response()->json($a);
    }
}
