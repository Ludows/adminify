<?php

namespace Ludows\Adminify\Http\Controllers\Back;

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
        public function showIndexPage(FormBuilder $formBuilder, Request $request)
        {
            
            $table = $this->table(PostTable::class);

            // dd($table->toArray());


            return $this->renderView('Index', [
                'model' => (object) [],
                'table' => $table->toArray()
            ]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function showCreatePage(FormBuilder $formBuilder)
        {
            //
            $form = $this->makeForm(CreatePost::class, [
                'method' => 'POST',
                'url' => route('admin.posts.store')
            ]);


            // dd($form->toArray());

            return $this->renderView('Create', [
                'model' => (object) [],
                'form' => $form->toArray()
            ]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function handleStore(CreatePostRequest $request)
        // public function store(Request $request)
        {
            //
            $form = $this->makeForm(CreatePost::class);
            $post = $this->postRepository->addModel(new Post())->create($form);

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'entity' => $post,
                'route' => 'admin.posts.index'
            ]);
        }

        /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function showPage($id)
        {
            //
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function showEditPage(Post $post, FormBuilder $formBuilder, Request $request)
        {
                $form = $this->makeForm(UpdatePost::class, [
                    'method' => 'PUT',
                    'url' => route('admin.posts.update', ['post' => $post->id]),
                    'model' => $post
                ]);


                return $this->renderView('Edit', [
                    'model' => $post,
                    'form' => $form->toArray()
                ]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function handleUpdate(Post $post, UpdatePostRequest $request)
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
                    'url' => route('admin.posts.update', ['post' => $post->id]),
                    'model' => $post
                ]);
            // }

            // if($isSeo) {
            //     $seo = $this->seoRepository->findOrCreate($post, $form);
            // }
            // else {
               $post = $this->postRepository->addModel($post)->update($form, $post);
            // }

            return $this->toJson([
                'message' => __('admin.typed_data.updated'),
                'entity' => $post,
                'route' => 'admin.posts.index'
            ]);

        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function handleDestroy(Post $post)
        {
            //
            //
            $this->postRepository->delete($post);

            return $this->toJson([
                'message' => __('admin.typed_data.deleted'),
                'entity' => $post,
                'route' => 'admin.posts.index'
            ]);
        }
}
