<?php

namespace Ludows\Adminify\Http\Controllers\Back;


use App\Adminify\Models\FormTrace;
use App\Adminify\Models\FormConfirmations;

use Illuminate\Http\Request;
use App\Adminify\Http\Requests\FormConfirmationRequest;

use App\Adminify\Repositories\FormTraceRepository;

use App\Adminify\Http\Controllers\Controller;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\FormConfirmation;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\FormTracesTable;

class FormsController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $formTraceRepository;

        public function __construct(FormTraceRepository $formTraceRepository) {

            $this->formTraceRepository = $formTraceRepository;

            $this->middleware(['permission:read|create_forms'], ['only' => ['show','create']]);
            $this->middleware(['permission:read|edit_forms'], ['only' => ['edit', 'update']]);
            $this->middleware(['permission:read|delete_forms'], ['only' => ['destroy']]);
        }


        public function getTrace(FormTrace $trace) {

            $entries = $trace->entries;

            $html = '';

            $html .= '<div class="table-responsive">
            <table class="table align-items-center table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">'. __('admin.formbuilder.namedfield') .'</th>
                    <th scope="col">'. __('admin.formbuilder.content') .'</th>

                </tr>
            </thead>
            <tbody>';

            foreach ($entries as $entry) {
                # code...
                $html .= '<tr>
                    <td>'. $entry->field_name .'</td>
                    <td>'. $entry->content .'</td>
                </tr>';
            }

            $html .= '</tbody>
        </table>
        </div>';



            return view("adminify::layouts.admin.pages.show", ['renderShow' => $html]);
        }
        public function getTraces(FormTrace $trace) {

            $table = $this->table(FormTracesTable::class);
            // dd($forms);
            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }
        public function destroyTrace(Forms $Form, FormTrace $trace) {

            $this->formTraceRepository->addModel($trace)->delete($trace);
            // redirect
            return $this->sendResponse($trace, 'forms.traces.index', 'admin.typed_data.deleted');

        }
}
