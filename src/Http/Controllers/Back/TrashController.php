<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

use App\Adminify\Models\Statuses;
class TrashController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:read|set_to_trash'], ['only' => ['index']]);
    }

    public function makeStatusRequest($type, $id, $status_id = 3) {
        $cl = adminify_get_class($type, ['app:models', 'app:adminify:models'], false);
        $enable_features = get_site_key('enables_features');
        $singular = singular($type);

        if($cl == null && isset($enable_features[$singular]) && $enable_features[ strtolower($singular) ] == false) {
            abort(403);
        }

        $m = new $cl;
        $m = $m->find($id);

        if(is_trashable_model($m)) {

            if( method_exists($m, 'shouldGenerateSlug') && $status_id == status()::PUBLISHED_ID) {
                $m->shouldGenerateSlug();
            }

            $m = $m->fill([
                'status_id' => $status_id
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

    public function handleUpdate(Request $request, $type, $id) {
        return $this->makeStatusRequest($type, $id, status()::PUBLISHED_ID);
    }

    public function showIndexPage(Request $request, $type, $id) {
        return $this->makeStatusRequest($type, $id, status()::TRASHED_ID);
    }
}
