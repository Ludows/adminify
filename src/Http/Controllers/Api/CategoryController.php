<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Ludows\Adminify\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;



use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $CategoryRepository;

    public function __construct(CategoryRepository $CategoryRepository)
    {
        $this->middleware('auth:sanctum', ['except' => ['index','show']]);
        $this->CategoryRepository = $CategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        //
        $model = $this->CategoryRepository->create($request->all(), $request);
        
        return response()->json([
            'entry' => $model,
            'message' => __('admin.success_entry_created'),
            'status' => 'OK'
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Category $Category)
    {
        return $Category;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCategoryRequest $request, Category $Category)
    {
        //
        $model = $this->CategoryRepository->update($request->all(), $request, $Category);
        
        return response()->json([
            'entry' => $model,
            'message' => __('admin.success_entry_updated'),
            'status' => 'OK'
        ]);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $Category)
    {
        //
        $m = $Category;

        $this->CategoryRepository->delete($Category);
        
        return response()->json([
            'entry' => $m,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}