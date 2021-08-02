<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTemplatesRequest;
use App\Http\Requests\UpdateTemplatesRequest;

use App\Models\Templates;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\CreateTemplates;
use App\Forms\UpdateTemplates;

use App\Repositories\TemplatesRepository;

use Ludows\Adminify\Traits\TableManagerable;
use Ludows\Adminify\Tables\TemplatesTable;

use Ludows\Adminify\Http\Controllers\Controller;

class TemplatesController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $templatesRepository;

    public function __construct(TemplatesRepository $templatesRepository) {

        $this->templatesRepository = $templatesRepository;
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

            $content_template = $this->templatesRepository->create($form, $request);

            if($request->ajax()) {
                return response()->json([
                    'templates' => $content_template,
                    'message' => __('admin.typed_data.success')
                ]);
            }
            else {
                flash(__('admin.typed_data.success'))->success();
                return redirect()->route('templates.index');
            }
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
                'url' => route('templates.update', ['category' => $template->id]),
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
                'url' => route('templates.update', ['category' => $template->id]),
                'model' => $template
            ]);

            $this->templatesRepository->update($form, $request, $template);
            flash(__('admin.typed_data.updated'))->success();
            return redirect()->route('templates.index');
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
            flash(__('admin.typed_data.deleted'))->success();
            return redirect()->route('templates.index');
        }
}
