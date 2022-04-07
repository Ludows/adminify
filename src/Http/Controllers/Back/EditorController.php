<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;
use Error;

class EditorController extends Controller
{
    public function preview(Request $request, $type, $id = null) {

        // cas du create
        // cas du edit  on a le model en question.
        $isCreate = !empty($type) && empty($id);
        $isEdit = !empty($type) && !empty($id);
        $isHome = false;

        // try to load the first one model
        $model = adminify_get_class(titled($type), ['app:adminify:models', 'app:models'], true);

        if(empty($model)) {
            // however we try to load model in singular
            $model = adminify_get_class(titled(singular($type)), ['app:adminify:models', 'app:models'], true);
        }

        // if you reedit a current model. We make sure that you bind the correct content.

        if($isEdit) {
            $model = $model->find($id);

            // now we can check if is homepage for correct handle controller response :)
            $isHome = is_homepage($model);
        }

        // if model is really empty. preview does not work properly. Throw Error.
        if(empty($model)) {
            throw new Error('Model with '.$type. 'cannot be found.');
        }



        if($isHome) {
            return app('Ludows\Adminify\Http\Controllers\Front\PageController')->index($request);
        }
        return app('Ludows\Adminify\Http\Controllers\Front\PageController')->getPages($model, $request);
    }
}
