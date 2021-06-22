<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Requests\CreateCategoryRequest;

use Ludows\Adminify\Models\Category;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Ludows\Adminify\Forms\CreateCategory;
use Ludows\Adminify\Forms\UpdateCategory;
use Ludows\Adminify\Http\Controllers\Controller;


use Ludows\Adminify\Repositories\CategoryRepository;


class CategoryController extends Controller
{
    use FormBuilderTrait;
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
            //
            if($request->useMultilang) {
                $categories = Category::lang($request->lang);
                // dd($categories);
                $categories = $categories->all();
            }
            else {
                $categories = Category::all();
            }

            $model = new Category();
            $fillables = $model->getFillable();
            $forms = array();

            foreach ($categories as $category) {
                # code...
                $category->checkForTraduction();

                $forms[] = $formBuilder->create(\App\Forms\DeleteCategory::class, [
                    'method' => 'DELETE',
                    'url' => route('categories.destroy', ['category' => $category->id])
                ]);
            }
            if(isset($categories) && count($categories) > 0) {
                $categories[0]->flashForMissing();
            }

            return view("layouts.admin.pages.index", ["datas" => $categories, 'thead' => $fillables, 'editParam' => 'category', 'forms' => $forms ]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            //
            $form = $formBuilder->create(\App\Forms\CreateCategory::class, [
                'method' => 'POST',
                'url' => route('categories.store')
            ]);

            // $formCreateCategory = $formBuilder->create(\App\Forms\CreateCategory::class, [
            //     'method' => 'POST',
            //     'action' => null
            // ]);

            // view()->share('formCreateCategory', $formCreateCategory);


            return view("layouts.admin.pages.create", ['form' => $form]);
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
                    'message' => 'La Catégorie a bien été créee !'
                ]);
            }
            else {
                flash('La Catégorie a bien été créee !')->success();
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
            $category->flashForMissing();

            $form = $formBuilder->create(\App\Forms\UpdateCategory::class, [
                'method' => 'PUT',
                'url' => route('categories.update', ['category' => $category->id]),
                'model' => $category
            ]);

            return view("layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Category $category, CreateCategoryRequest $request)
        {
            //


            $form = $this->form(UpdateCategory::class, [
                'method' => 'PUT',
                'url' => route('categories.update', ['category' => $category->id]),
                'model' => $category
            ]);

            $this->categoryRepository->update($form, $request, $category);
            flash('La Catégorie a bien été mise à jour !')->success();
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
            flash('La Catégorie a bien été supprimée !')->success();
            return redirect()->route('categories.index')->with('status', 'La Catégorie a bien été supprimée !');
        }
}
