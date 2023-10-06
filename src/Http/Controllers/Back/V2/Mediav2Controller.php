<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;


use App\Adminify\Models\Media;

use Illuminate\Http\Request;

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

use Ludows\Adminify\Libs\MediaService;

class Mediav2Controller extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $mediaRepository;

        public function __construct(MediaRepository $mediaRepository, MediaService $MediaService) {

            $this->mediaRepository = $mediaRepository;
            $this->mediaUploader = $MediaService;

            $this->middleware(['permission:read|create_medias'], ['only' => ['index','upload']]);
            // $this->middleware(['permission:read|edit_medias'], ['only' => ['edit', 'update']]);
            // $this->middleware(['permission:read|delete_medias'], ['only' => ['destroy']]);
        }

    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function showIndexPage(FormBuilder $formBuilder)
        {
            $listing =  $this->mediaUploader->getFiles();
            $config = $this->mediaUploader->getConfig();
            $dates = $this->mediaUploader->getListingDates();
            $types = $this->mediaUploader->getListingTypedFiles();

            $a = ['files' => $listing->files, 'thumbs' => $config['thumbs'], 'dates' => $dates, 'types' => $types];
            
            $views = $this->getPossiblesViews('Index');

            // dd($table->toArray());

            return $this->renderView($views, array_merge([
                'model' => (object) [],
            ], $a));
        }

        public function upload(Request $request) {

            $input = $request->all();
            $entity = null; 

            $isValid = $this->mediaUploader->validate($input);
            $config = $this->mediaUploader->getConfig();

            if($isValid) {
                $entity = $this->mediaUploader->setFileUpload($input[$config['paramName']])->upload();
            }

            return $this->toJson([
                'message' => __('admin.typed_data.success'),
                'entity' => $entity,
                'route' => 'admin.medias.index'
            ]);

        }

        public function listing() {
// 'files' => $this->mediaUploader->getFiles(),
            $listing =  $this->mediaUploader->getFiles();
            $config = $this->mediaUploader->getConfig();
            $dates = $this->mediaUploader->getListingDates();
            $types = $this->mediaUploader->getListingTypedFiles();
            

            return $this->toJson(['files' => $listing->files, 'thumbs' => $config['thumbs'], 'dates' => $dates, 'types' => $types]);
        }

        public function handleUpdate(Media $media, Request $request)
        {
            //
            $inputs = $request->all();

            $this->mediaRepository->addModel($media)->update($inputs, $media);

            return $this->toJson([
                'message' => __('admin.typed_data.updated'),
                'entity' => $media,
                'route' => 'admin.medias.index'
            ]);
        }

        public function handleDestroy(Media $media)
        {

            $this->mediaUploader->setModel($media)->destroy();
            return $this->toJson([
                'message' => __('admin.typed_data.deleted'),
                'entity' => $media,
                'route' => 'admin.medias.index'
            ]);
        }
    }
