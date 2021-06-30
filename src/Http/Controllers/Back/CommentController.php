<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Models\Comment;
use Ludows\Adminify\Models\Post;
use Kris\LaravelFormBuilder\FormBuilder;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Repositories\CommentRepository;
use Ludows\Adminify\Dropdowns\Comment as CommentDropdownManager;
use Illuminate\Support\Str;

use Ludows\Adminify\Forms\DeleteCrud;
use Ludows\Adminify\Forms\UpdateComment;


class CommentController extends Controller
{
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        private $commentRepository;
        public function __construct(CommentRepository $commentRepository)
        {
            $this->commentRepository = $commentRepository;
        }
        public function index(Request $request, FormBuilder $formBuilder)
        {
            //
            if($request->useMultilang) {
                $comments = Comment::lang($request->lang, 'comment');
                // dd($categories);
                $comments = $comments->all();
            }
            else {
                $comments = Comment::all();
            }
            $model = new Comment();
            $fillables = $model->getFillable();

            $a = new CommentDropdownManager($comments, []);

            return view("adminify::layouts.admin.pages.index", ["datas" => $comments, 'dropdownManager' => $a,  'thead' => $fillables]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(Request $request)
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
        public function update(Request $request, Comment $comment)
        {
            //
            $comment = $this->commentRepository->update($request->all(), $comment);

            if($request->ajax()) {
                return response()->json([
                    'commentList' => $comment->post->commentsThree
                ]);
            }
            else {
                flash('Le Commentaire a bien été mis à jour !')->success();
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
                    'status' => 'Le Commentaire a bien supprimé'
                ]);
            }
            else {
                flash('Le Commentaire a bien supprimé')->success();
                return redirect()->route('comments.index');
            }
        }
}
