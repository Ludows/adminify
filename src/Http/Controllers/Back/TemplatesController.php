<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Requests\CreateTemplatesRequest;
use App\Adminify\Http\Requests\UpdateTemplatesRequest;

use App\Adminify\Models\Templates;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Adminify\Forms\CreateTemplates;
use App\Adminify\Forms\UpdateTemplates;

use App\Adminify\Repositories\TemplatesRepository;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\TemplatesTable;

use App\Adminify\Http\Controllers\Controller;

class TemplatesController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $templatesRepository;

    public function __construct(TemplatesRepository $templatesRepository) {

        $this->templatesRepository = $templatesRepository;

        $this->middleware(['permission:read|create_templates'], ['only' => ['show','create', 'setContent']]);
        $this->middleware(['permission:read|edit_templates'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_templates'], ['only' => ['destroy']]);
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(FormBuilder $formBuilder, Request $request)
        {
            $table = $this->table(TemplatesTable::class);

            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            //
            $form = $formBuilder->create(CreateTemplates::class, [
                'method' => 'POST',
                'url' => route('templates.store')
            ]);

            return view("adminify::layouts.admin.pages.create", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateTemplatesRequest $request)
        {
            // we pass context and request
            $form = $this->form(CreateTemplates::class);

            $content_template = $this->templatesRepository->addModel(new Templates())->create($form);

            return $this->sendResponse($content_template, 'templates.index', 'admin.typed_data.success');
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function edit(FormBuilder $formBuilder, Templates $template, Request $request)
        {
            //
            $template->checkForTraduction();
            // $category->flashForMissing();

            $form = $formBuilder->create(UpdateTemplates::class, [
                'method' => 'PUT',
                'url' => route('templates.update', ['template' => $template->id]),
                'model' => $template
            ]);

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Templates $template, UpdateTemplatesRequest $request)
        {
            //


            $form = $this->form(UpdateTemplates::class, [
                'method' => 'PUT',
                'url' => route('templates.update', ['template' => $template->id]),
                'model' => $template
            ]);

            $this->templatesRepository->addModel($template)->update($form, $template);
            return $this->sendResponse($template, 'templates.index', 'admin.typed_data.updated');
        }

        public function setContent(Request $request) {
            $all = $request->all();
            if(!isset($all['items'])) {
                abort(403);
            }
            $template = Templates::find($all['items']);

            return response()->json([
                'html' => $template->content,
                'message' => __('admin.typed_data.success')
            ]);
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(Templates $template)
        {
            //
            $this->templatesRepository->delete($template);

            // redirect
            return $this->sendResponse($template, 'templates.index', 'admin.typed_data.deleted');
        }
}
