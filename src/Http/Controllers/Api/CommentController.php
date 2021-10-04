<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Adminify\Models\Comment;
use App\Adminify\Repositories\CommentRepository;
use Ludows\Adminify\Http\Controllers\Controller;

use App\Adminify\Http\Requests\CreateCommentRequest;
use App\Adminify\Http\Requests\UpdateCommentRequest;


use Illuminate\Http\Request;
use App\Adminify\Models\User;
use App\Adminify\Models\Role;

class CommentController extends Controller
{
    private $CommentRepository;

    public function __construct(CommentRepository $CommentRepository)
    {
        $this->middleware(function ($request, $next) {
            $u = user();
            $this->user = $u != null ? $u : User::find(Role::GUEST);
    
            return $next($request);
        });
        $this->CommentRepository = $CommentRepository;
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
        return Comment::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCommentRequest $request)
    {
        //
        if(!$this->user->tokenCan('api:create')) {
            abort(403);
        };

        $model = $this->CommentRepository->addModel(new Comment())->create($request->all());
        
        return response()->json([
            'commentList' => $model->post->commentsThree,
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
        if(!$this->user->tokenCan('api:read')) {
            abort(403);
        };

        return $Comment;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $Comment)
    {
        //
        if(!$this->user->tokenCan('api:update')) {
            abort(403);
        };

        $model = $this->CommentRepository->addModel($Comment)->update($request->all(), $Comment);
        
        return response()->json([
            'commentList' => $model->post->commentsThree,
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

        if(!$this->user->tokenCan('api:delete')) {
            abort(403);
        };
        //
        $m = $Comment;

        $this->CommentRepository->addModel($Comment)->delete($Comment);
        
        return response()->json([
            'commentList' => $m->post->commentsThree,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}