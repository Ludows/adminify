<?php

namespace Ludows\Adminify\Http\Controllers\Back;


use App\Models\Media;

use App\Http\Requests\CreateMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Repositories\MediaRepository;

use Ludows\Adminify\Http\Controllers\Controller;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Forms\CreateMedia;
use App\Forms\UpdateMedia;

use Ludows\Adminify\Traits\TableManagerable;
use Ludows\Adminify\Tables\MediaTable;

class MediaController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $mediaRepository;

        public function __construct(MediaRepository $mediaRepository) {

            $this->mediaRepository = $mediaRepository;
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
            $form = $formBuilder->create(CreateMedia::class, [
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
                if($request->ajax()) {
                    return response()->json([
                        'media' => $media,
                        'status' => __('admin.typed_data.success')
                    ]);
                }
                else {
                    flash(__('admin.typed_data.success'))->success();
                    return redirect()->route('medias.index');
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
        public function edit(Media $media, FormBuilder $formBuilder)
        {
            //
            $form = $formBuilder->create(UpdateMedia::class, [
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

            $form = $this->form(UpdateMedia::class, [
                'method' => 'PUT',
                'url' => route('medias.update', ['media' => $media->id]),
                'model' => $media
            ]);

            $this->mediaRepository->addModel($media)->update($form, $media);

            if($request->ajax()) {
                return response()->json([
                    'media' => $media,
                    'status' => __('admin.typed_data.updated')
                ]);
            }
            else {
                flash(__('admin.typed_data.updated'))->success();
                return redirect()->route('medias.index');
            }
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
            // redirect
            flash(__('admin.typed_data.deleted'))->success();
            return redirect()->route('medias.index');
        }
}
