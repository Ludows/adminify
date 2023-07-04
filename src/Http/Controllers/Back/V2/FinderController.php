<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Ludows\Adminify\Libs\SitemapRender;

class FinderController extends Controller
{
    public function index(Request $request, $type) {

        $resource = Str::title($type);
        $resoucable = adminify_get_class( singular($resource), ['app:adminify:models', 'app:models'], false);
        $shareds = inertia()->getShared();

        $multi = $shareds['useMultilang'];
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
            'results' => $m,
            'labelToShow' => $labelToShow
        ];

        return $this->toJson($a);

        // return response()->json($a);
    }
}
