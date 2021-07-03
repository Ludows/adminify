<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Models\Post;
use Ludows\Adminify\Repositories\PostRepository;
use Ludows\Adminify\Http\Controllers\Controller;
use Ludows\Adminify\Http\Requests\CreatePostRequest;


use Illuminate\Http\Request;

class PostController extends Controller
{
    private $PostRepository;

    public function __construct(PostRepository $PostRepository)
    {
        $this->middleware('auth:sanctum', ['except' => ['index','show']]);
        $this->PostRepository = $PostRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return $Post;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePostRequest $request, Post $Post)
    {
        //
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
        $m = $Post;

        $this->PostRepository->delete($Post);
        
        return response()->json([
            'entry' => $m,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}