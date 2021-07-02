<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use Ludows\Adminify\Models\Comment;
use Ludows\Adminify\Repositories\CommentRepository;
use Ludows\Adminify\Http\Controllers\Controller;


use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $CommentRepository;

    public function __construct(CommentRepository $CommentRepository)
    {
        $this->middleware('auth:sanctum', ['except' => ['index','show']]);
        $this->CommentRepository = $CommentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comment::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $model = $this->CommentRepository->create($request->all());
        
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
    public function show(Comment $Comment)
    {
        return $Comment;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $Comment)
    {
        //
        $model = $this->CommentRepository->update($request->all(), $Comment);
        
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
    public function destroy(Comment $Comment)
    {
        //
        $m = $Comment;

        $this->CommentRepository->delete($Comment);
        
        return response()->json([
            'entry' => $m,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}