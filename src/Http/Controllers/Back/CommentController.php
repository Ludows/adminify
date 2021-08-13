<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Kris\LaravelFormBuilder\FormBuilderTrait;
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
        use FormBuilderTrait;

        public function __construct(CommentRepository $commentRepository)
        {
            $this->commentRepository = $commentRepository;
        }
        public function index(Request $request, FormBuilder $formBuilder)
        {
            //
            $table = $this->table(CommentTable::class, [
                'showBtnCreate' => true,
            ]);

            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
            public function create(FormBuilder $formBuilder)
            {
                //
                $form = $formBuilder->create(CreateComment::class, [
                    'method' => 'POST',
                    'url' => route('comments.store')
                ]);
    
                return view("adminify::layouts.admin.pages.create", ['form' => $form]);
            }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateCommentRequest $request)
        {
            // we pass context and request
            $form = $this->form(CreateComment::class);

            $comment = $this->commentRepository->addModel(new Comment())->create($form);

            if($request->ajax()) {
                return response()->json([
                    'commentList' => $comment->post->commentsThree,
                    'message' => __('admin.typed_data.success')
                ]);
            }
            else {
                flash(__('admin.typed_data.success'))->success();
                return redirect()->route('comments.index');
            }
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
            $form = $this->form(UpdateComment::class);

            $comment = $this->commentRepository->addModel($comment)->update($form, $comment);

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

            $this->commentRepository->addModel($comment)->delete($comment);
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
