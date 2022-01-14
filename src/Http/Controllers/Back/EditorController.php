<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Repositories\BaseRepository;

use Ludows\Adminify\Traits\TableManagerable;


class EditorController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $Repository;

    public function __construct(BaseRepository $Repository) {

        $this->baseRepo = $Repository;
        $this->middleware(['permission:read|create_pages'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_pages'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_pages'], ['only' => ['destroy']]);
    }
    public function addWidget($widget, Request $request) {

        $classStr = adminify_get_class($widget, ['app:widgets', 'app:adminify:widgets'], false);
        $editor = json_decode( $request->get('editor') , true);
        $config = $editor['config'];
        $return_datas = [];

        // dd($request->all(), $config);


        switch ($widget) {
            case 'ColumnWidget':
                # code...
                $count = intval( $config['count'] ?? '1' );

                for ($i=0 ; $i < $count; $i++) {
                    # code...
                    $widgetObject = new $classStr;

                    $widgetObject->config = $config;

                    $return_datas[] = $widgetObject->handle();
                }
                break;

            default:
                $widgetObject = new $classStr;

                $widgetObject->config = $config;
                # code...
                $return_datas[] = $widgetObject->handle();
                break;
        }



        return $this->sendResponse($return_datas, url()->previous(), 'admin.typed_data.success', 'data');
    }
    public function autosave() {}
    public function duplicateBlock(Request $request) {
        $html = '';
        $duplicate = json_decode( $request->get('duplicate') , true);


        return $this->sendResponse($duplicate, url()->previous(), 'admin.typed_data.success', 'data');
    }
    public function getTemplate($id) {

        if(empty($id)) {
            abort(404);
        }

        $theTpl = $this->baseRepo->getGeneratedFilesWithContentByEditor($id);

        return response()->json([
            'status' => 'OK',
            'data' => $theTpl
        ]);
    }

}
