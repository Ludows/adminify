<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;

use App\Models\Category;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\CreateCategory;
use App\Forms\UpdateCategory;
use App\Forms\DeleteCrud;
use Ludows\Adminify\Http\Controllers\Controller;
use Ludows\Adminify\Dropdowns\Category as CategoryDropdownManager;


use App\Repositories\CategoryRepository;
use Ludows\Adminify\Traits\TableManagerable;


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
            //
            $config = config('site-settings.listings');

            if($request->useMultilang) {
                $categories = Category::limit( $config['limit'] )->lang($request->lang);
                // dd($categories);
                // $categories = $categories->all()->limit( $config['limit'] )->get();
            }
            else {
                $categories = Category::limit( $config['limit'] )->get();
            }

            $model = new Category();
            $fillables = $model->getFillable();

            $a = new CategoryDropdownManager($categories, []);

            if(isset($categories) && count($categories) > 0) {
                $categories[0]->flashForMissing();
            }

            return view("adminify::layouts.admin.pages.index", ["datas" => $categories, 'thead' => $fillables, 'dropdownManager' => $a ]);
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

            // $formCreateCategory = $formBuilder->create(\App\Forms\CreateCategory::class, [
            //     'method' => 'POST',
            //     'action' => null
            // ]);

            // view()->share('formCreateCategory', $formCreateCategory);


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
