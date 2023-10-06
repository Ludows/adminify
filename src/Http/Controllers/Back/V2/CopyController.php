<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

class CopyController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:read|set_to_trash'], ['only' => ['index']]);
    }
    public function showIndexPage(Request $request, $type, $id) {


        // $type = $request->type;
        // $id = $request->id;
        $cl = adminify_get_class(\Str::studly($type), ['app:models', 'app:adminify:models'], false);

        if(empty($cl)) {
            abort(403);
        }

        $m = new $cl;
        $m = $m->find($id);

        $new_m = $m->replicate();

        if(!empty($new_m->title)) {
            $new_m->title = $new_m->title. ' - Copy';
        }

        if( method_exists($new_m, 'shouldGenerateSlug') ) {
            $new_m->shouldGenerateSlug();
        }

        $new_m->created_at = now();
        $new_m->updated_at = now();

        if(!empty($new_m->user_id)) {
            $new_m->user_id = user()->id;
        }

        $new_m->save();

        return $this->toJson([
            'message' => __('admin.typed_data.duplicated'),
            'entity' => $new_m,
            'url' => url()->previous()
        ]);
    }
}
