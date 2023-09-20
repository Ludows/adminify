<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

class MediaManipulationController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:read'], ['only' => ['index']]);
    }

    public function update(Request $request, $id) {

    }

    public function destroy(Request $request, $id) {

    }

    public function index(Request $request , $id) {
        $views = $this->getPossiblesViews('Index');
        $media = model('Media');
        $media = $media->find($id);

        if(empty($media)) {
            abort(403);
        }

        // dd($table->toArray());


        return $this->renderView($views, [
            'model' => (object) [],
            'thumbs' => $media->thumbs
            // 'table' => $table->toArray()
        ]);
    }
}
