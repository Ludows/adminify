<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\CreateTag as CreateTagForm;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTagRequest as CreateTagRequest;
use App\Models\Tag as TagModel;

use App\Repositories\TagRepository;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Traits\TableManagerable;
use Ludows\Adminify\Tables\TagTable;


class TagsController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $tagRepository;

    public function __construct(TagRepository $tagRepository) {

        $this->tagRepository = $tagRepository;
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(Request $request, FormBuilder $formBuilder)
        {

            $table = $this->table(new TagTable());

            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            $form = $formBuilder->create(CreateTagForm::class, [
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
            $form = $this->form(CreateTagForm::class);
            $tag = $this->tagRepository->create($form, $request);
            if($request->ajax()) {
                return response()->json([
                    'tag' => $tag,
                    'status' => __('admin.typed_data.success')
                ]);
            }
            else {
                flash(__('admin.typed_data.success'))->success();
                return redirect()->route('tags.index');
            }
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

            $form = $formBuilder->create(CreateTagForm::class, [
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
        public function update(TagModel $tag, FormBuilder $formBuilder, CreateTagRequest $request)
        {
            //
            $form = $this->form(CreateTagForm::class, [
                'method' => 'PUT',
                'url' => route('tags.update', ['traduction' => $tag->id]),
                'model' => $tag
            ]);

            $this->tagRepository->update($form, $request, $tag);

            if($request->ajax()) {
                return response()->json([
                    'tag' => $tag,
                    'status' => __('admin.typed_data.updated')
                ]);
            }
            else {
                flash(__('admin.typed_data.updated'))->success();
                return redirect()->route('tags.index');
            }
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
            $this->tagRepository->delete($tag);

            // redirect
            flash(__('admin.typed_data.deleted'))->success();
            return redirect()->route('tags.index');
        }
}
