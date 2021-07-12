<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;


use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\CreatePost;
use App\Forms\UpdatePost;
use App\Forms\DeleteCrud;
use App\Forms\SeoForm;
use App\Forms\SaveMissingTraductions;

use App\Models\Post;
use Ludows\Adminify\Http\Controllers\Controller;


use App\Repositories\PostRepository;
use App\Repositories\SeoRepository;

use Ludows\Adminify\Traits\TableManagerable;
use Ludows\Adminify\Tables\PostTable;

class PostController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $postRepository;
    private $seoRepository;

    public function __construct(PostRepository $postRepository, SeoRepository $seoRepository) {

        $this->postRepository = $postRepository;
        $this->seoRepository = $seoRepository;
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(FormBuilder $formBuilder, Request $request)
        {
            
            $table = $this->table(new PostTable());

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
            $form = $formBuilder->create(CreatePost::class, [
                'method' => 'POST',
                'url' => route('posts.store')
            ]);

            return view("adminify::layouts.admin.pages.create", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreatePostRequest $request)
        {
            //
            $form = $this->form(CreatePost::class);
            $post = $this->postRepository->create($form, $request);
            if($request->ajax()) {
                return response()->json([
                    'media' => $post,
                    'status' => 'Le Post a bien été crée !'
                ]);
            }
            else {
                flash('Le Post a bien été crée !')->success();
                return redirect()->route('posts.index');
            }
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
        public function edit(Post $post, FormBuilder $formBuilder, Request $request)
        {
            //
            // dd($request->exists('seo'));

            $post->checkForTraduction();
            // $post->flashForMissing();

            if($request->exists('seo')) {
                $form = $formBuilder->create(SeoForm::class, [
                    'method' => 'PUT',
                    'url' => route('posts.update', ['post' => $post->id]),
                    'model' => $post
                ]);
            }
            else if($request->exists('missingTraductions') && $request->useMultilang) {

                $clsForm = $this->form(UpdatePost::class);

                $form = $formBuilder->create(SaveMissingTraductions::class, [
                    'method' => 'PUT',
                    'url' => route('savetraductions.update'),
                ], [
                    'clsForm' => $clsForm,
                    'model' => $post
                ]);
            }
            else {
                $form = $formBuilder->create(UpdatePost::class, [
                    'method' => 'PUT',
                    'url' => route('posts.update', ['post' => $post->id]),
                    'model' => $post
                ]);
            }

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Post $post, CreatePostRequest $request)
        {
            //
            $isSeo = $request->exists('_seo');
            $seo = null;

            if($isSeo) {
                $form = $this->form(SeoForm::class, [
                    'method' => 'PUT',
                    'url' => route('posts.update', ['post' => $post->id]),
                    'model' => $post
                ]);
            }
            else {
                $form = $this->form(UpdatePost::class, [
                    'method' => 'PUT',
                    'url' => route('posts.update', ['post' => $post->id]),
                    'model' => $post
                ]);
            }

            if($isSeo) {
                $seo = $this->seoRepository->findOrCreate($post, $form);
            }
            else {
               $post = $this->postRepository->update($form, $request, $post);
            }


            if($request->ajax()) {
                return response()->json([
                    'media' => $post,
                    'status' => 'Le Post a bien été mis à jour !'
                ]);
            }
            else {
                flash('Le Post a bien été mis à jour !')->success();
                return redirect()->route('posts.index');
            }
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(Post $post)
        {
            //
            //
            $this->postRepository->delete($post);

            // redirect
            flash('Le Post a bien été supprimé !')->success();
            return redirect()->route('posts.index');
        }
}
