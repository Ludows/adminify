<?php

namespace Ludows\Adminify\Http\Controllers\Back;


use App\Models\Media;

use App\Http\Requests\CreateMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\Storage;
use Ludows\Adminify\Http\Controllers\Controller;

use File;

use Illuminate\Support\Str;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\CreateMedia;
use App\Forms\UpdateMedia;
use App\Forms\DeleteCrud;

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
            
            $table = $this->table(new MediaTable());
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
                $media = $this->mediaRepository->create($form, $request);
                if($request->ajax()) {
                    return response()->json([
                        'media' => $media,
                        'status' => 'Le Media a bien été crée !'
                    ]);
                }
                else {
                    flash('Le Media a bien été crée !')->success();
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

            $this->mediaRepository->update($form, $request, $media);

            if($request->ajax()) {
                return response()->json([
                    'media' => $media,
                    'status' => 'Le Media a bien été mis à jour !'
                ]);
            }
            else {
                flash('Le Media a bien été mis à jour !')->success();
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

            $this->mediaRepository->delete($media);
            // redirect
            flash('Le Media a bien été supprimé !')->success();
            return redirect()->route('medias.index');
        }
}
