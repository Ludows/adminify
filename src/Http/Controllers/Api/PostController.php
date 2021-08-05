<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Models\Post;
use App\Repositories\PostRepository;
use Ludows\Adminify\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;


use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;

class PostController extends Controller
{
    private $PostRepository;

    public function __construct(PostRepository $PostRepository)
    {
        $this->middleware(function ($request, $next) {
            $u = user();
            $this->user = $u != null ? $u : User::find(Role::GUEST);
    
            return $next($request);
        });
        $this->PostRepository = $PostRepository;
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

        return Post::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        //
        if(!$this->user->tokenCan('api:create')) {
            abort(403);
        };

        $model = $this->PostRepository->create($request->all(), $request);
        
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
    public function show(Post $Post)
    {
        if(!$this->user->tokenCan('api:read')) {
            abort(403);
        };

        return $Post;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $Post)
    {
        //
        if(!$this->user->tokenCan('api:update')) {
            abort(403);
        };

        $model = $this->PostRepository->update($request->all(), $request, $Post);
        
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
    public function destroy(Post $Post)
    {
        //
        if(!$this->user->tokenCan('api:delete')) {
            abort(403);
        };

        $m = $Post;

        $this->PostRepository->delete($Post);
        
        return response()->json([
            'entry' => $m,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}