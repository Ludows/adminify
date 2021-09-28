<?php

namespace Ludows\Adminify\Http\Controllers\Back;


use App\Models\Forms;

use App\Http\Requests\CreateFormsRequest;
use App\Http\Requests\UpdateFormsRequest;
use App\Repositories\FormsRepository;

use Ludows\Adminify\Http\Controllers\Controller;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Forms\CreateForms;
use App\Forms\UpdateForms;

use Ludows\Adminify\Traits\TableManagerable;
use Ludows\Adminify\Tables\FormsTable;

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
            $form = $formBuilder->create(CreateForms::class, [
                'method' => 'POST',
                'url' => route('forms.store')
            ]);
            //
            return view("adminify::layouts.admin.pages.create", ['form' => $form]);
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
                if($request->ajax()) {
                    return response()->json([
                        'form' => $Form,
                        'status' => __('admin.typed_data.success')
                    ]);
                }
                else {
                    flash(__('admin.typed_data.success'))->success();
                    return redirect()->route('forms.index');
                }

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

            if($request->ajax()) {
                return response()->json([
                    'form' => $Form,
                    'status' => __('admin.typed_data.updated')
                ]);
            }
            else {
                flash(__('admin.typed_data.updated'))->success();
                return redirect()->route('forms.index');
            }
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
            flash(__('admin.typed_data.deleted'))->success();
            return redirect()->route('forms.index');
        }
}
