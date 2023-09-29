<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use App\Adminify\Http\Requests\CreateCategoryRequest;
use App\Adminify\Http\Requests\UpdateCategoryRequest;

use App\Adminify\Models\Category;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Adminify\Forms\CreateCategory;
use App\Adminify\Forms\UpdateCategory;

use App\Adminify\Repositories\CategoryRepository;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\CategoryTable;

use App\Adminify\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {

        $this->categoryRepository = $categoryRepository;
        $this->middleware(['permission:read|create_categories'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_categories'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_categories'], ['only' => ['destroy']]);
    }

    
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(FormBuilder $formBuilder, Request $request)
        {
            $table = $this->table(CategoryTable::class);

            $views = $this->getPossiblesViews('Index');

            // dd($table->toArray());


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
        public function create(FormBuilder $formBuilder)
        {
            //
            $form = $this->makeForm(CreateCategory::class, [
                'method' => 'POST',
                'url' => route('admin.categories.store')
            ]);

            $views = $this->getPossiblesViews('Create');

            return $this->renderView($views, [
                'model' => (object) [],
                'form' => $form->toArray()
            ]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateCategoryRequest $request)
        {
            // we pass context and request
            $form = $this->makeForm(CreateCategory::class);

            $category = $this->categoryRepository->addModel(new Category())->create($form);

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'entity' => $category,
                'route' => 'admin.categories.index'
            ]);

            // if($request->ajax()) {
            //     return response()->json([
            //         'category' => $category,
            //         'message' => __('admin.typed_data.success')
            //     ]);
            // }
            // else {
            //     flash(__('admin.typed_data.success'))->success();
            //     return redirect()->route('categories.index');
            // }
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
        public function edit(FormBuilder $formBuilder, Category $category, Request $request)
        {
            //
            $category->checkForTraduction();
            // $category->flashForMissing();

            $form = $this->makeForm(UpdateCategory::class, [
                'method' => 'PUT',
                'url' => route('admin.categories.update', ['category' => $category->id]),
                'model' => $category
            ]);

            $views = $this->getPossiblesViews('Edit');

            return $this->renderView($views, [
                'model' => $category,
                'form' => $form->toArray()
            ]);

        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Category $category, UpdateCategoryRequest $request)
        {
            //


            $form = $this->makeForm(UpdateCategory::class, [
                'method' => 'PUT',
                'url' => route('admin.categories.update', ['category' => $category->id]),
                'model' => $category
            ]);

            $this->categoryRepository->addModel($category)->update($form, $category);

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'entity' => $category,
                'route' => 'admin.categories.index'
            ]);
            // flash(__('admin.typed_data.updated'))->success();
            // return redirect()->route('categories.index');
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(Category $category)
        {
            //
            $this->categoryRepository->addModel($category)->delete($category);

            //redirect
            return $this->toJson([
                'message' => __('admin.typed_data.deleted'),
                'entity' => $category,
                'route' => 'admin.categories.index'
            ]);
        }
}
