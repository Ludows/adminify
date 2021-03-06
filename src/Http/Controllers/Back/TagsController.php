<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Adminify\Forms\CreateTag as CreateTagForm;

use Illuminate\Http\Request;
use App\Adminify\Http\Requests\CreateTagRequest as CreateTagRequest;
use App\Adminify\Http\Requests\UpdateTagRequest as UpdateTagRequest;
use App\Adminify\Models\Tag as TagModel;

use App\Adminify\Repositories\TagRepository;
use App\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\TagTable;


class TagsController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $tagRepository;

    public function __construct(TagRepository $tagRepository) {

        $this->tagRepository = $tagRepository;
        $this->middleware(['permission:read|create_tags'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_tags'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_tags'], ['only' => ['destroy']]);
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(Request $request, FormBuilder $formBuilder)
        {

            $table = $this->table(TagTable::class);

            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            $form = $this->makeForm(CreateTagForm::class, [
                'method' => 'POST',
                'url' => route('tags.store')
            ]);
            //
            return view("adminify::layouts.admin.pages.create", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateTagRequest $request)
        {
            //
            $form = $this->makeForm(CreateTagForm::class);
            $tag = $this->tagRepository->addModel(new TagModel())->create($form);

            return $this->sendResponse($tag, 'tags.index', 'admin.typed_data.success');
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function edit(TagModel $tag, FormBuilder $formBuilder)
        {
            // Etonnant laravel ne comprends pas l'object Traduction.

            $tag->checkForTraduction();
            // $traduction->flashForMissing();

            $form = $this->makeForm(CreateTagForm::class, [
                'method' => 'PUT',
                'url' => route('tags.update', ['tag' => $tag->id]),
                'model' => $tag
            ]);

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(TagModel $tag, FormBuilder $formBuilder, UpdateTagRequest $request)
        {
            //
            $form = $this->makeForm(CreateTagForm::class, [
                'method' => 'PUT',
                'url' => route('tags.update', ['traduction' => $tag->id]),
                'model' => $tag
            ]);

            $this->tagRepository->addModel($tag)->update($form, $tag);

            return $this->sendResponse($tag, 'tags.index', 'admin.typed_data.updated');
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(TagModel $tag)
        {
            //
            $this->tagRepository->addModel($tag)->delete($tag);

            // redirect
            return $this->sendResponse($tag, 'tags.index', 'admin.typed_data.deleted');
        }
}
