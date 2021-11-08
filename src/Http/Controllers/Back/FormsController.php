<?php

namespace Ludows\Adminify\Http\Controllers\Back;


use App\Adminify\Models\Forms;
use App\Adminify\Models\FormTrace;

use Illuminate\Http\Request;
use App\Adminify\Http\Requests\CreateFormsRequest;
use App\Adminify\Http\Requests\UpdateFormsRequest;
use App\Adminify\Repositories\FormsRepository;

use App\Adminify\Http\Controllers\Controller;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\CreateForms;
use App\Adminify\Forms\UpdateForms;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\FormsTable;
use App\Adminify\Tables\FormTracesTable;

class FormsController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $Repository;

        public function __construct(FormsRepository $Repository) {

            $this->Repository = $Repository;

            $this->middleware(['permission:read|create_forms'], ['only' => ['show','create']]);
            $this->middleware(['permission:read|edit_forms'], ['only' => ['edit', 'update']]);
            $this->middleware(['permission:read|delete_forms'], ['only' => ['destroy']]);
        }

    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(FormBuilder $formBuilder)
        {

            $table = $this->table(FormsTable::class);
            // dd($forms);
            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {

            $interface = interfaces('formbuilder');

            // $form = $formBuilder->create(CreateForms::class, [
            //     'method' => 'POST',
            //     'url' => route('forms.store')
            // ]);
            //
            return view("adminify::layouts.admin.pages.create", ['interface' => $interface]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateFormsRequest $request)
        {
                // we pass context and request
                $form = $this->form(CreateForms::class);

                // the create method return the media created
                $Form = $this->Repository->addModel(new Forms())->create($form);

                return $this->sendResponse($Form, 'forms.index', 'admin.typed_data.success');
        }

        /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function show($id)
        {
            //
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function edit(Forms $Form, FormBuilder $formBuilder)
        {
            //
            // $form = $formBuilder->create(UpdateForms::class, [
            //     'method' => 'PUT',
            //     'url' => route('forms.update', ['form' => $Form->id]),
            //     'model' => $Form
            // ]);
            $interface = interfaces('formbuilder');


            return view("adminify::layouts.admin.pages.edit", ['interface' => $interface]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Forms $Form, UpdateFormsRequest $request)
        {
            //

            $form = $this->form(UpdateForms::class, [
                'method' => 'PUT',
                'url' => route('forms.update', ['form' => $Form->id]),
                'model' => $Form
            ]);

            $this->Repository->addModel($Form)->update($form, $Form);

            return $this->sendResponse($Form, 'forms.index', 'admin.typed_data.updated');
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(Forms $Form)
        {

            $this->Repository->addModel($Form)->delete($Form);
            // redirect
            return $this->sendResponse($Form, 'forms.index', 'admin.typed_data.deleted');

        }

        //todo more cleaner as helper func ?
        public function getChoiceOptionsRenderer($type) {

            $expanded = false;
            $multiple = false;
            $config = config('laravel-form-builder.defaults');

            $choice_option = [];

            switch ($type) {
                case 'select:multiple':
                    # code...
                    $multiple = true;
                    $choice_option = [];
                    break;
                case 'radio':
                    # code...
                    $expanded = true;
                    $choice_option = $config['radio'];

                    break;
                case 'checkbox':
                    # code...
                    $expanded = true;
                    $multiple = true;

                    $choice_option = $config['checkbox'];
                    break;
            }

            return [
                'choices' => ['example-1' => 'Example 1', 'example-2' => 'Example 2', 'example-3' => 'Example 3'],
                'choice_options' => $choice_option,
                'selected' => [],
                'expanded' => $expanded,
                'multiple' => $multiple
            ];
        }

        public function getFieldExample($all = [], $json = true) {
            $key = uuid(20);

            if(!empty($all['key'])) {
                $key = $all['key'];
            }
            $pattern_name = 'example_'.$key;

            $FormBuilder = app('Kris\LaravelFormBuilder\FormBuilder');

            if(!isset($all['type'])) {
                abort(403);
            }
            $concat_arr = array();

            if(is_integer( strpos($all['type'], 'choice') )) {
                $spl_str = explode('.', $all['type']);

                $concat_arr = $this->getChoiceOptionsRenderer($spl_str[1]);
                $all['type'] = 'choice';
            }


            $optionsFields = [
                [
                    'name' => $pattern_name,
                    'type' => $all['type'],
                    'attr' => [
                        'data-functional' => $key,
                        'data-original-label' => $pattern_name
                    ],
                    'help_block' => [
                        'text' => null,
                        'tag' => 'p',
                        'attr' => ['id' => 'helpblock_'.$key,  'class' => 'help-block d-none']
                    ],
                    'errors' => [
                        'id' => 'errors_'.$key,
                        'class' => 'text-danger d-none',
                        'text' => null
                    ],
                ],
            ];

            $optionsFields[0] = array_merge($optionsFields[0] , $concat_arr);

            $optionForm = [
                'method' => 'POST',
                'url' => route('forms.validate')
            ];

            $form = $FormBuilder->createByArray($optionsFields,$optionForm);

            $return_statement = [
                'status' => 'OK',
                'html' => form_row($form->{$pattern_name}),
                'uuid_field_key' => $key,
                'preview_form_options' => $optionsFields,
            ];

            if($json) {
                return response()->json($return_statement);
            }
            else {
                return $return_statement;
            }
        }

        public function addField(Request $request, FormBuilder $FormBuilder) {

            $all = $request->all();

            $response_field = $this->getFieldExample($all);

            return $response_field;

        }
        public function getDeleteField(Request $request) {
            $all = $request->all();

            if(!isset($all['id']) && !isset($all['field_id'])) {
                abort(403);
            }

            $Form = new Forms();
            $Form = $Form->where('id', $all['id'])->get()->first();
            $FormFieldsId = $Form->fields()->wherePivot('form_field_id', '!=', $all['field_id'])->get()->all();

            $a = [];

            foreach ($FormFieldsId as $FormFieldId) {
                # code...
                $a[$FormFieldId->id] = ['order' => $FormFieldId->pivot->order];
            }

            $synced = $Form->fields()->sync($a);

            return $this->sendResponse($Form, 'forms.index', 'admin.typed_data.updated');
        }
        public function getConfirmation() {}
        public function getTrace(Forms $Form, FormTrace $trace) {

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
        public function getTraces(Forms $Form) {

            if(empty($Form->id)) {
                abort(404);
            }

            $table = $this->table(FormTracesTable::class);
            // dd($forms);
            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }
        public function storeConfirmation() {}
        public function deleteEntries() {}
}
