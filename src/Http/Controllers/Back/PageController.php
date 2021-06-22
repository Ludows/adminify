<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Ludows\Adminify\Models\Page;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Ludows\Adminify\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Illuminate\Support\Str;

use Ludows\Adminify\Http\Requests\PageRequest;

use Ludows\Adminify\Repositories\PageRepository;
use Ludows\Adminify\Repositories\SeoRepository;

use Ludows\Adminify\Actions\Page as PageAction;

class PageController extends Controller
{
     /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        use FormBuilderTrait;
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
            $model = new Page();
            $fillables = $model->getFillable();



            if($request->useMultilang) {
                $pages = Page::lang($request->lang);
                // dd($categories);
                $pages = $pages->all();
            }
            else {
                $pages = Page::all();
            }

            $actions = array();

            foreach ($pages as $page) {
                # code...
                $page->checkForTraduction();
                $actions[] = new PageAction($page, [
                    'form' => $formBuilder->create(\App\Forms\DeleteCrud::class, [
                        'method' => 'DELETE',
                        'url' => route('pages.destroy', ['page' => $page->id])
                    ])
                ]);

            }

            if(isset($pages) && count($pages) > 0) {
                $pages[0]->flashForMissing();
            }
            return view("layouts.admin.pages.index", ["datas" => $pages, 'actions' => $actions, 'thead' => $fillables]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            $form = $formBuilder->create(\App\Forms\CreatePage::class, [
                'method' => 'POST',
                'url' => route('pages.store')
            ]);
            //
            return view("layouts.admin.pages.create", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(PageRequest $request)
        {
            //
            $form = $this->form(\App\Forms\CreatePage::class);
            $page = $this->pageRepository->create($form, $request);
            if($request->ajax()) {
                return response()->json([
                    'page' => $page,
                    'status' => 'La Page a bien été créee !'
                ]);
            }
            else {
                flash('La Page a bien été créee !')->success();
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
            $page->flashForMissing();

            // dd($page);

            if($request->exists('seo')) {
                $form = $formBuilder->create(\App\Forms\SeoForm::class, [
                    'method' => 'PUT',
                    'url' => route('pages.update', ['page' => $page->id]),
                    'model' => $page
                ]);
            }
            else {
                $form = $formBuilder->create(\App\Forms\CreatePage::class, [
                    'method' => 'PUT',
                    'url' => route('pages.update', ['page' => $page->id]),
                    'model' => $page
                ]);
            }


            return view("layouts.admin.pages.edit", ['form' => $form]);
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
                $form = $this->form(\App\Forms\SeoForm::class, [
                    'method' => 'PUT',
                    'url' => route('pages.update', ['page' => $page->id]),
                    'model' => $page
                ]);
            }
            else {
                $form = $this->form(\App\Forms\CreatePage::class);
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
                    'status' => 'La Page a bien été mise à jour !'
                ]);
            }
            else {
                flash('La Page a bien été mise à jour !')->success();
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
            flash('La Page a bien été supprimée !')->success();
            return redirect()->route('pages.index');
        }
}
