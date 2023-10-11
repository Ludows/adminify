<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use App\Adminify\Models\Page;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\CreatePage;
use App\Adminify\Forms\UpdatePage;

use App\Adminify\Http\Requests\CreatePageRequest;
use App\Adminify\Http\Requests\UpdatePageRequest;

use App\Adminify\Repositories\PageRepository;
use App\Adminify\Repositories\SeoRepository;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\PageTable;
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

            $this->middleware(['permission:read|create_pages'], ['only' => ['show','create']]);
            $this->middleware(['permission:read|edit_pages'], ['only' => ['edit', 'update']]);
            $this->middleware(['permission:read|delete_pages'], ['only' => ['destroy']]);
        }

        public function showIndexPage(FormBuilder $formBuilder, Request $request)
        {
            $table = $this->table(PageTable::class);

            $views = $this->getPossiblesViews('Index');

            return $this->renderView($views, [
                'model' => (object) [],
                'table' => $table->toArray()
            ]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function showCreatePage(FormBuilder $formBuilder)
        {
            $form = $this->makeForm(CreatePage::class, [
                'method' => 'POST',
                'url' => route('admin.pages.store')
            ]);

            $views = $this->getPossiblesViews('Create');

            return $this->renderView($views, [
                'model' => (object) [],
                'form' => $form->toArray()
            ]);
            //
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function handleStore(CreatePageRequest $request)
        {
            //
            $form = $this->makeForm(CreatePage::class);
            $page = $this->pageRepository->addModel(new Page())->create($form);

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'entity' => $page,
                'route' => 'admin.pages.index'
            ]);

        }

        /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function showPage($id)
        {
            //
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function showEditPage(Page $page, FormBuilder $formBuilder, Request $request)
        {
            //
            $page->checkForTraduction();
                $form = $this->makeForm(UpdatePage::class, [
                    'method' => 'PUT',
                    'url' => route('admin.pages.update', ['page' => $page->id]),
                    'model' => $page
                ]);
        
            $views = $this->getPossiblesViews('Edit');

            return $this->renderView($views, [
                'model' => $page,
                'form' => $form->toArray()
            ]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function handleUpdate(UpdatePageRequest $request, Page $page)
        {
            //
            // $isSeo = $request->exists('_seo');
            $seo = null;

            // if($isSeo) {
            //     $form = $this->form(SeoForm::class, [
            //         'method' => 'PUT',
            //         'url' => route('pages.update', ['page' => $page->id]),
            //         'model' => $page
            //     ]);
            // }
            // else {
                $form = $this->makeForm(UpdatePage::class);
            // }

            // if($isSeo) {
            //     $seo = $this->seoRepository->addModel($page)->findOrCreate($page, $form);
            // }
            // else {
                $page = $this->pageRepository->addModel($page)->update($form, $page);
            // }

            return $this->toJson([
                'message' => __('admin.typed_data.updated'),
                'entity' => $page,
                'route' => 'admin.pages.index'
            ]);

            // return $this->sendResponse($page, 'pages.index', 'admin.typed_data.updated');

        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function handleDestroy(Page $page)
        {
            //
            $this->pageRepository->addModel($page)->delete($page);

            return $this->toJson([
                'message' => __('admin.typed_data.deleted'),
                'entity' => $page,
                'route' => 'admin.pages.index'
            ]);

            // redirect
            // return $this->sendResponse($page, 'pages.index', 'admin.typed_data.deleted');
        }
}
