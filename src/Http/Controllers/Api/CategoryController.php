<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Adminify\Models\Category;
use App\Adminify\Repositories\CategoryRepository;
use Ludows\Adminify\Http\Controllers\Controller;
use App\Adminify\Http\Requests\CreateCategoryRequest;
use App\Adminify\Http\Requests\UpdateCategoryRequest;



use Illuminate\Http\Request;
use App\Adminify\Models\User;
use App\Adminify\Models\Role;

class CategoryController extends Controller
{
    private $CategoryRepository;

    public function __construct(CategoryRepository $CategoryRepository)
    {
        $this->middleware(function ($request, $next) {
            $u = user();
            $this->user = $u != null ? $u : User::find(Role::GUEST);
    
            return $next($request);
        });
        $this->CategoryRepository = $CategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!$this->user->tokenCan('api:read')) {
            abort(403);
        };
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
        if(!$this->user->tokenCan('api:create')) {
            abort(403);
        };

        $model = $this->CategoryRepository->addModel(new Category())->create($request->all());
        
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
        if(!$this->user->tokenCan('api:read')) {
            abort(403);
        };

        return $Category;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $Category)
    {
        //
        if(!$this->user->tokenCan('api:update')) {
            abort(403);
        };

        $model = $this->CategoryRepository->addModel($Category)->update($request->all(), $Category);
        
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
        if(!$this->user->tokenCan('api:delete')) {
            abort(403);
        };
        
        $m = $Category;

        $this->CategoryRepository->addModel($Category)->delete($Category);
        
        return response()->json([
            'entry' => $m,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}