<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Kris\LaravelFormBuilder\FormBuilder;
use Ludows\Adminify\Http\Controllers\Controller;

use App\Repositories\CommentRepository;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

use App\Forms\UpdateComment;

use Ludows\Adminify\Traits\TableManagerable;
use Ludows\Adminify\Tables\CommentTable;


class CommentController extends Controller
{
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        private $commentRepository;
        use TableManagerable;
        public function __construct(CommentRepository $commentRepository)
        {
            $this->commentRepository = $commentRepository;
        }
        public function index(Request $request, FormBuilder $formBuilder)
        {
            //
            $table = $this->table(CommentTable::class, [
                'showBtnCreate' => false,
            ]);

            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateCommentRequest $request)
        {
            //
            $comment = $this->commentRepository->create($request->all());

            return response()->json([
                'commentList' => $comment->post->commentsThree
            ]);
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
        public function edit(FormBuilder $formBuilder, Comment $comment, Request $request)
        {
            //
            $form = $formBuilder->create(UpdateComment::class, [
                'method' => 'PUT',
                'url' => route('comments.update', ['comment' => $comment->id]),
                'model' => $comment
            ]);

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(UpdateCommentRequest $request, Comment $comment)
        {
            //
            $comment = $this->commentRepository->update($request->all(), $comment);

            if($request->ajax()) {
                return response()->json([
                    'commentList' => $comment->post->commentsThree
                ]);
            }
            else {
                flash(__('admin.typed_data.updated'))->success();
                return redirect()->route('comments.index');
            }
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(Request $request, Comment $comment)
        {
            //

            $all = $request->all();

            $this->commentRepository->delete($comment);
            $m = Post::find($all['post_id']);
            if($request->ajax()) {
                return response()->json([
                    'commentList' => $m->commentsThree,
                    'status' => __('admin.typed_data.deleted')
                ]);
            }
            else {
                flash(__('admin.typed_data.deleted'))->success();
                return redirect()->route('comments.index');
            }
        }
}
