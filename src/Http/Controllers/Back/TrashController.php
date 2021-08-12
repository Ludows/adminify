<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;

use App\Models\Statuses;
class TrashController extends Controller
{
    public function index(Request $request) {


        $type = $request->type;
        $id = $request->id;

        $cl = get_site_key('register.'.$type);

        if($cl == null) {
            abort(403);
        }

        $m = new $cl;
        $m = $m->find($id);

        if(is_trashable_model($m)) {
            
            $m = $m->fill([
                'status_id' => Statuses::TRASHED_ID
            ]);

            $m->save();

            flash(__('admin.typed_data.updated'))->success();
            return redirect(url()->previous());
        }
        else {
            return abort(403);
        }
    }
}
