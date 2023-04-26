<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use App\Adminify\Http\Requests\CreatePostRequest;
use App\Adminify\Http\Requests\UpdatePostRequest;


use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\CreatePost;
use App\Adminify\Forms\UpdatePost;
use App\Adminify\Forms\SeoForm;

use App\Adminify\Models\Post;
use App\Adminify\Http\Controllers\Controller;


use App\Adminify\Repositories\PostRepository;
use App\Adminify\Repositories\SeoRepository;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\PostTable;


class PostController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $postRepository;
    private $seoRepository;

    public function __construct(PostRepository $postRepository, SeoRepository $seoRepository) {

        $this->postRepository = $postRepository;
        $this->seoRepository = $seoRepository;

        $this->middleware(['permission:read|create_posts'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_posts'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_posts'], ['only' => ['destroy']]);
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(FormBuilder $formBuilder, Request $request)
        {
            
            $table = $this->table(PostTable::class);

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
            $form = $this->makeForm(CreatePost::class, [
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
            $form = $this->makeForm(CreatePost::class);
            $post = $this->postRepository->addModel(new Post())->create($form);

            return $this->sendResponse($post, 'posts.index', 'admin.typed_data.success');
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

            // if($request->exists('seo')) {
            //     $form = $formBuilder->create(SeoForm::class, [
            //         'method' => 'PUT',
            //         'url' => route('posts.update', ['post' => $post->id]),
            //         'model' => $post
            //     ]);
            // }
            // else {
                $form = $this->makeForm(UpdatePost::class, [
                    'method' => 'PUT',
                    'url' => route('posts.update', ['post' => $post->id]),
                    'model' => $post
                ]);
            // }

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Post $post, UpdatePostRequest $request)
        {
            //
            // $isSeo = $request->exists('_seo');
            // $seo = null;

            // if($isSeo) {
            //     $form = $this->form(SeoForm::class, [
            //         'method' => 'PUT',
            //         'url' => route('posts.update', ['post' => $post->id]),
            //         'model' => $post
            //     ]);
            // }
            // else {
                $form = $this->makeForm(UpdatePost::class, [
                    'method' => 'PUT',
                    'url' => route('posts.update', ['post' => $post->id]),
                    'model' => $post
                ]);
            // }

            // if($isSeo) {
            //     $seo = $this->seoRepository->findOrCreate($post, $form);
            // }
            // else {
               $post = $this->postRepository->addModel($post)->update($form, $post);
            // }

            return $this->sendResponse($post, 'posts.index', 'admin.typed_data.updated');
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
            return $this->sendResponse($post, 'posts.index', 'admin.typed_data.deleted');
        }
}
