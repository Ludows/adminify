<?php

namespace Ludows\Adminify\Http\Controllers\Back;


use App\Adminify\Models\Forms;

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
            $form = $formBuilder->create(UpdateForms::class, [
                'method' => 'PUT',
                'url' => route('forms.update', ['form' => $Form->id]),
                'model' => $Form
            ]);

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
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

        public function addField(Request $request, FormBuilder $FormBuilder) {

            $all = $request->all();

            if(!isset($all['type'])) {
                abort(403);
            }
            $key = uuid(20);
            $pattern_name = 'example_'.$key;

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
                        'class' => 'text-danger',
                        'text' => 'Some Dummy Text'
                    ],
                ],
            ];

            $optionForm = [
                'method' => 'POST',
                'url' => route('forms.validate')
            ];


            $form = $FormBuilder->createByArray($optionsFields,$optionForm);

            return response()->json([
                'status' => 'OK',
                'html' => form_row($form->{$pattern_name}),
                'uuid_field_key' => $key,
                'preview_form_options' => $optionsFields,
            ]);

        }
}
