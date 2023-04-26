<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;
use Error;

class EditorController extends Controller
{
    public function preview(Request $request, $type, $id = null) {

        // cas du create
        // cas du edit  on a le model en question.
        $content = json_decode($request->getContent(), true);

        if(array_is_list($content)) {
            if($request->isHome) {
                return app('Ludows\Adminify\Http\Controllers\Front\PageController')->index($request);
            }
            return app('Ludows\Adminify\Http\Controllers\Front\PageController')->getPages($request);
        }

        return view('blocs::'.$content['_name'], $content);


    }
}
