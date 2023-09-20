<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Adminify\Models\Post;
use App\Adminify\Repositories\PostRepository;
use Ludows\Adminify\Http\Controllers\ApiBaseController as Controller;
use App\Adminify\Http\Requests\CreatePostRequest;
use App\Adminify\Http\Requests\UpdatePostRequest;


use Illuminate\Http\Request;

use App\Adminify\Models\User;
use App\Adminify\Models\Role;

class PostController extends Controller
{
    private $PostRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        dd($this->user);

        if(!$this->user->tokenCan('api:read')) {
            abort(403);
        };

        // return Post::all();
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
        // if(!$this->user->tokenCan('api:create')) {
        //     abort(403);
        // };

        // $model = $this->PostRepository->addModel(new Post())->create($request->all());
        
        // return response()->json([
        //     'entry' => $model,
        //     'message' => __('admin.success_entry_created'),
        //     'status' => 'OK'
        // ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Post $Post)
    {
        // if(!$this->user->tokenCan('api:read')) {
        //     abort(403);
        // };

        // return $Post;
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
        // if(!$this->user->tokenCan('api:update')) {
        //     abort(403);
        // };

        // $model = $this->PostRepository->addModel($Post)->update($request->all(), $Post);
        
        // return response()->json([
        //     'entry' => $model,
        //     'message' => __('admin.success_entry_updated'),
        //     'status' => 'OK'
        // ]);

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
        // if(!$this->user->tokenCan('api:delete')) {
        //     abort(403);
        // };

        // $m = $Post;

        // $this->PostRepository->addModel($Post)->delete($Post);
        
        // return response()->json([
        //     'entry' => $m,
        //     'message' => __('admin.success_entry_deleted'),
        //     'status' => 'OK'
        // ]);
    }
}