<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

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

            $views = $this->getPossiblesViews('Index');


            return $this->renderView($views, [
                'model' => (object) [],
                'table' => $table->toArray()
            ]);

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
                    'url' => route('admin.comments.store')
                ]);

                $views = $this->getPossiblesViews('Create');

                return $this->renderView($views, [
                    'model' => (object) [],
                    'form' => $form->toArray()
                ]);

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

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'three' => $comment->commentsThree,
                'route' => 'admin.comments.index'
            ]);

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
                'url' => route('admin.comments.update', ['comment' => $comment->id]),
                'model' => $comment
            ]);

            $views = $this->getPossiblesViews('Edit');

            return $this->renderView($views, [
                'model' => $category,
                'form' => $form->toArray()
            ]);
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
            $form = $this->makeForm(UpdateComment::class, [
                'model' => $comment
            ]);

            $comment = $this->commentRepository->addModel($comment)->update($form, $comment);

            return $this->toJson([
                'message' => __('admin.typed_data.updated'),
                'three' => $comment->commentsThree,
                'route' => 'admin.comments.index'
            ]);
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

            $model = new $comment->model_class;
            $model = $model->find( (int) $comment->model_id );

            $this->commentRepository->addModel($comment)->delete($comment);

            return $this->toJson([
                'message' => __('admin.typed_data.deleted'),
                'three' => $model->commentsThree,
                'route' => 'admin.comments.index'
            ]);

            // return $this->sendResponse($model->commentsThree, 'comments.index', 'admin.typed_data.deleted', 'commentList');
        }
}
