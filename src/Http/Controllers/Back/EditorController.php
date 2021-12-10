<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Requests\CreateMailRequest;
use App\Adminify\Http\Requests\UpdateMailRequest;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Http\Controllers\Controller;

use App\Adminify\Repositories\MailsRepository;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\MailsTable;

use App\Adminify\Forms\CreateMail;
use App\Adminify\Forms\UpdateMail;

use App\Adminify\Models\Mailables;
use Mail;


class EditorController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $mailRepository;

    public function __construct(MailsRepository $mailRepository) {

        $this->mailRepository = $mailRepository;
        $this->middleware(['permission:read|create_pages'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_pages'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_pages'], ['only' => ['destroy']]);
    }
    public function addWidget($widget, Request $request) {

        $classStr = adminify_get_class($widget, ['app:widgets', 'app:adminify:widgets'], false);
        $config = $request->get('config');
        $return_datas = [];


        switch ($widget) {
            case 'ColumnWidget':
                # code...
                $count = intval( $config['count'] );

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
    public function removeWidget() {}
    public function autosave() {}
    public function generateStyles() {}
    public function generateJs() {}

}
