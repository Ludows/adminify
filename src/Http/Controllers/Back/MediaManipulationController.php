<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

class MediaManipulationController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:read'], ['only' => ['index']]);
    }

    public function handleUpdate(Request $request, $id) {

    }

    public function handleDestroy(Request $request, $id) {

    }

    public function showIndexPage(Request $request , $id) {
        $media = model('Media');
        $media = $media->find($id);

        if(empty($media)) {
            abort(403);
        }

        // dd($table->toArray());


        return $this->renderView('Index', [
            'model' => (object) [],
            'thumbs' => $media->thumbs
            // 'table' => $table->toArray()
        ]);
    }
}
