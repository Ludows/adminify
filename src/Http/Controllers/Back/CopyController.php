<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

class CopyController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:read|set_to_trash'], ['only' => ['index']]);
    }
    public function index(Request $request, $type, $id) {


        // $type = $request->type;
        // $id = $request->id;

        $cl = adminify_get_class($type, ['app:models', 'app:adminify:models'], false);

        if(empty($cl)) {
            abort(403);
        }

        $m = new $cl;
        $m = $m->find($id);

        $new_m = $m->replicate();

        $new_m->created_at = now();
        $new_m->updated_at = now();

        $new_m->save();

        return $this->sendResponseWith($new_m, url()->previous(), 'admin.typed_data.duplicated');

    }
}
