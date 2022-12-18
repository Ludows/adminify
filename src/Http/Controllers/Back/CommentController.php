<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Models\Comment;
use App\Adminify\Models\Post;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Adminify\Http\Controllers\Controller;

use App\Adminify\Repositories\CommentRepository;

use App\Adminify\Http\Requests\CreateCommentRequest;
use App\Adminify\Http\Requests\UpdateCommentRequest;

use App\Adminify\Forms\CreateComment;
use App\Adminify\Forms\UpdateComment;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\CommentTable;


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
            
            $this->middleware(['permission:read|create_comments'], ['only' => ['show','create']]);
            $this->middleware(['permission:read|edit_comments'], ['only' => ['edit', 'update']]);
            $this->middleware(['permission:read|delete_comments'], ['only' => ['destroy']]);
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
                $form = $this->makeForm(CreateComment::class, [
                    'method' => 'POST',
                    'url' => route('comments.store')
                ]);

                $this->addJS( asset('/adminify/back/js/comments.js') );
    
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
            $form = $this->makeForm(CreateComment::class);

            $comment = $this->commentRepository->addModel(new Comment())->create($form);

            return $this->sendResponse($comment->post->commentsThree, 'comments.index', 'admin.typed_data.success', 'commentList');
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
            $form = $this->makeForm(UpdateComment::class, [
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
            $form = $this->makeForm(UpdateComment::class);

            $comment = $this->commentRepository->addModel($comment)->update($form, $comment);

            return $this->sendResponse($comment->post->commentsThree, 'comments.index', 'admin.typed_data.updated', 'commentList');
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

            return $this->sendResponse($m->commentsThree, 'comments.index', 'admin.typed_data.deleted', 'commentList');
        }
}
