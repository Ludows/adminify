<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use App\Models\Page;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\DeleteCrud;
use App\Forms\CreatePage;
use App\Forms\SeoForm;


use App\Http\Requests\PageRequest;

use App\Repositories\PageRepository;
use App\Repositories\SeoRepository;

use Ludows\Adminify\Traits\TableManagerable;
use Ludows\Adminify\Tables\PageTable;
class PageController extends Controller
{
     /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        use FormBuilderTrait;
        use TableManagerable;
        private $pageRepository;
        private $actionable;
        private $seoRepository;

        public function __construct(PageRepository $pageRepository, SeoRepository $seoRepository)
        {
            $this->pageRepository = $pageRepository;
            $this->seoRepository = $seoRepository;
        }

        public function index(FormBuilder $formBuilder, Request $request)
        {
            $table = $this->table(new PageTable());
            
            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            $form = $formBuilder->create(CreatePage::class, [
                'method' => 'POST',
                'url' => route('pages.store')
            ]);
            //
            return view("adminify::layouts.admin.pages.create", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(PageRequest $request)
        {
            //
            $form = $this->form(CreatePage::class);
            $page = $this->pageRepository->create($form, $request);
            if($request->ajax()) {
                return response()->json([
                    'page' => $page,
                    'status' => __('admin.typed_data.success')
                ]);
            }
            else {
                flash(__('admin.typed_data.success'))->success();
                return redirect()->route('pages.index');
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
        public function edit(Page $page, FormBuilder $formBuilder, Request $request)
        {
            //
            $page->checkForTraduction();
            // $page->flashForMissing();

            // dd($page);

            if($request->exists('seo')) {
                $form = $formBuilder->create(SeoForm::class, [
                    'method' => 'PUT',
                    'url' => route('pages.update', ['page' => $page->id]),
                    'model' => $page
                ]);
            }
            else {
                $form = $formBuilder->create(CreatePage::class, [
                    'method' => 'PUT',
                    'url' => route('pages.update', ['page' => $page->id]),
                    'model' => $page
                ]);
            }


            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(PageRequest $request, Page $page)
        {
            //
            $isSeo = $request->exists('_seo');
            $seo = null;

            if($isSeo) {
                $form = $this->form(SeoForm::class, [
                    'method' => 'PUT',
                    'url' => route('pages.update', ['page' => $page->id]),
                    'model' => $page
                ]);
            }
            else {
                $form = $this->form(CreatePage::class);
            }

            if($isSeo) {
                $seo = $this->seoRepository->findOrCreate($page, $form);
            }
            else {
                $page = $this->pageRepository->update($form, $request, $page);
            }

            if($request->ajax()) {
                return response()->json([
                    'page' => $page,
                    'status' => __('admin.typed_data.updated')
                ]);
            }
            else {
                flash(__('admin.typed_data.updated'))->success();
                return redirect()->route('pages.index');
            }
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(Page $page)
        {
            //
            $this->pageRepository->delete($page);

            // redirect
            flash(__('admin.typed_data.deleted'))->success();
            return redirect()->route('pages.index');
        }
}
