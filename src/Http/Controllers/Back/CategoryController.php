<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

use App\Models\Category;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\CreateCategory;
use App\Forms\UpdateCategory;

use App\Repositories\CategoryRepository;

use Ludows\Adminify\Traits\TableManagerable;
use Ludows\Adminify\Tables\CategoryTable;

use Ludows\Adminify\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {

        $this->categoryRepository = $categoryRepository;
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(FormBuilder $formBuilder, Request $request)
        {
            $table = $this->table(new CategoryTable());            

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
            $form = $formBuilder->create(CreateCategory::class, [
                'method' => 'POST',
                'url' => route('categories.store')
            ]);

            return view("adminify::layouts.admin.pages.create", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateCategoryRequest $request)
        {
            // we pass context and request
            $form = $this->form(CreateCategory::class);

            $category = $this->categoryRepository->create($form, $request);

            if($request->ajax()) {
                return response()->json([
                    'category' => $category,
                    'message' => __('admin.typed_data.success')
                ]);
            }
            else {
                flash(__('admin.typed_data.success'))->success();
                return redirect()->route('categories.index');
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
        public function edit(FormBuilder $formBuilder, Category $category, Request $request)
        {
            //
            $category->checkForTraduction();
            // $category->flashForMissing();

            $form = $formBuilder->create(UpdateCategory::class, [
                'method' => 'PUT',
                'url' => route('categories.update', ['category' => $category->id]),
                'model' => $category
            ]);

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
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


            $form = $this->form(UpdateCategory::class, [
                'method' => 'PUT',
                'url' => route('categories.update', ['category' => $category->id]),
                'model' => $category
            ]);

            $this->categoryRepository->update($form, $request, $category);
            flash(__('admin.typed_data.updated'))->success();
            return redirect()->route('categories.index');
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
            $this->categoryRepository->delete($category);

            // redirect
            flash(__('admin.typed_data.deleted'))->success();
            return redirect()->route('categories.index');
        }
}
