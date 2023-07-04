<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

use App\Adminify\Models\Statuses;
class TrashController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:read|set_to_trash'], ['only' => ['index']]);
    }
    public function index(Request $request, $type, $id) {


        // $type = $request->type;
        // $id = $request->id;

        $cl = adminify_get_class($type, ['app:models', 'app:adminify:models'], false);
        $enable_features = get_site_key('enables_features');
        $singular = singular($type);

        if($cl == null && isset($enable_features[$singular]) && $enable_features[ strtolower($singular) ] == false) {
            abort(403);
        }

        $m = new $cl;
        $m = $m->find($id);

        if(is_trashable_model($m)) {

            $m = $m->fill([
                'status_id' => Statuses::TRASHED_ID
            ]);

            $m->save();

            return $this->toJson([
                'entity' => $m,
                'url' => url()->previous(),
                'message' => 'admin.typed_data.updated'
            ]);

        }
        else {
            return abort(403);
        }
    }
}
