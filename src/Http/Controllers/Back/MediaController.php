<?php

namespace Ludows\Adminify\Http\Controllers\Back;


use App\Adminify\Models\Media;

use App\Adminify\Http\Requests\CreateMediaRequest;
use App\Adminify\Http\Requests\UpdateMediaRequest;
use App\Adminify\Repositories\MediaRepository;

use App\Adminify\Http\Controllers\Controller;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\CreateMedia;
use App\Adminify\Forms\UpdateMedia;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\MediaTable;

class MediaController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $mediaRepository;

        public function __construct(MediaRepository $mediaRepository) {

            $this->mediaRepository = $mediaRepository;

            $this->middleware(['permission:read|create_medias'], ['only' => ['show','create']]);
            $this->middleware(['permission:read|edit_medias'], ['only' => ['edit', 'update']]);
            $this->middleware(['permission:read|delete_medias'], ['only' => ['destroy']]);
        }

    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(FormBuilder $formBuilder)
        {
            
            $table = $this->table(MediaTable::class);
            // dd($forms);
            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            $form = $this->makeForm(CreateMedia::class, [
                'method' => 'POST',
                'url' => route('medias.store')
            ]);
            //
            return view("adminify::layouts.admin.pages.create", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateMediaRequest $request)
        {
                // we pass context and request
                $form = $this->form(CreateMedia::class);

                // the create method return the media created
                $media = $this->mediaRepository->addModel(new Media())->create($form);
                return $this->sendResponse($media, 'medias.index', 'admin.typed_data.success');
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
        public function edit(Media $media, FormBuilder $formBuilder)
        {
            //
            $form = $this->makeForm(UpdateMedia::class, [
                'method' => 'PUT',
                'url' => route('medias.update', ['media' => $media->id]),
                'model' => $media
            ]);

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Media $media, UpdateMediaRequest $request)
        {
            //

            $form = $this->makeForm(UpdateMedia::class, [
                'method' => 'PUT',
                'url' => route('medias.update', ['media' => $media->id]),
                'model' => $media
            ]);

            $this->mediaRepository->addModel($media)->update($form, $media);

            return $this->sendResponse($media, 'medias.index', 'admin.typed_data.updated');
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(Media $media)
        {

            app('UniSharp\LaravelFilemanager\Controllers\DeleteController')->getDelete();

            $this->mediaRepository->addModel($media)->delete($media);
            return $this->sendResponse($media, 'medias.index', 'admin.typed_data.deleted');            
        }
}
