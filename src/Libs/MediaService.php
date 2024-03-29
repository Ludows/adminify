<?php

namespace Ludows\Adminify\Libs;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\File;
use App\Adminify\Repositories\MediaRepository;
use App\Adminify\Models\Media;

class MediaService {
    public function __construct(Request $request, MediaRepository $mediaRepository, Media $media) {
        $this->request = $request;
        $this->mediaRepository = $mediaRepository;
        $this->config = get_site_key('media_library');
        $this->filesytem = storage($this->config['driver']);
        $this->order = 'desc';
        $this->file = null;
        $this->model = $media;
    }
    public function getListingTypedFiles() {
        return [
            '*' => __('admin.media.all'),
            'image/' => __('admin.media.images'),
            'video/' => __('admin.media.videos'),
            'audio/' => __('admin.media.sounds'),
            'text/' => __('admin.media.documents'),
            'office/' => __('admin.media.spreadsheets'),
            'application/zip' => __('admin.media.archives'),
        ];
    }
    public function getMicrosoftOfficeMimeTypes() {

    }
    public function url($fileName) {
        $fileSystem = $this->getFileSystem();
        return $fileSystem->url($fileName);
    }
    public function relativeUrl($fileName) {
        $url = $this->url($fileName);
        $fileSystem = $this->getFileSystem();
        return str_replace($fileSystem->url(''), '', $url);
    }
    public function getFileSystem() {
        return $this->filesytem;
    }
    public function getRequest() {
        return $this->request;
    }
    public function getConfig() {
        return $this->config;
    }
    public function setOrder($value) {
        $this->order = $value;
        return $this;
    }
    public function getModel() {
        return $this->model;
    }
    public function setModel($value) {
        $this->model = $value;
        return $this;
    }
    public function getOrder() {
        return $this->order;
    }
    public function getFilesByDate($folderDateString = null) {
        if(is_null($folderDateString)) {
            throw new Exception('You must give a folder to find files for media library', 500);
        }

        $fileSystem = $this->getFileSystem();
        $files = $fileSystem->files($folderDateString);

        return $files;
    }
    public function getListingDates() {
        $fileSystem = $this->getFileSystem();
        $directories = $fileSystem->directories('');

        $directories = array_filter($directories, function($value) {
            return $value != '.cache';
        });

        $dates = [
            '*' => __('admin.media.all'),
        ];

        foreach ($directories as $key => $value) {
            # code...
            $dates[$value] = $value;
        }

        return $dates;
    }
    public function getFiles() {
        // dd()
        $files = [];
        $model = $this->getModel();
        $config = $this->getConfig();
        $request = $this->getRequest();
        $query = $model;
        $inputs = $request->all();
        $pageInt = 1;


        if(!empty($inputs['search'])) {
            $query = $query->src("%{$inputs['search']}%", 'like');
        }

        if(!empty($inputs['documents']) && $inputs['documents'] != "*") {
            $query = $query->mimetype("%{$inputs['documents']}%", 'like');
        }

        if(!empty($inputs['date']) && $inputs['date'] != "*") {
            $query = $query->folder($inputs['date']);
        }

        if(!empty($inputs['page'])) {
            $pageInt = (int) $inputs['page'];
        }

        $paginator = $query->latest()->paginate($config['limit'], ['*'], 'page', $pageInt)->withPath( route('medias.index') );


        return (object) [
            'files' => $paginator,
        ];
    }
    public function validate($input, $messages = []) {

        $config = $this->getConfig();
        $rule = [
            $config['paramName'] =>  $config['validator_rule']
        ];
        $validate = Validator::make($input, $rule , $messages);
        return $validate;
    }
    public function setFileUpload($file) {
        $this->file = $file;
        return $this;
    }
    public function getFileUpload() {
        return $this->file;
    }
    public function upload() {
        $fileUpload = $this->getFileUpload();
        $hasFileToUpload = !empty($fileUpload);
        $fileSystem = $this->getFileSystem();
        $config = $this->getConfig();
        $namedFile = '';

        $dt = Carbon::now();

        if($config['allow_rename']) {
            $name = $fileUpload->hashName(); // Generate a unique, random name...
            $extension = $fileUpload->extension(); // Determine the file's extension based on the file's MIME type...
            $namedFile = $name.'.'.$extension;
        }
        else {
            // ensure file as slug
            $name = slug( explode('.',$fileUpload->getClientOriginalName())[0] );
            $extension = $fileUpload->getClientOriginalExtension();
            $namedFile = $name.'.'.$extension;
        }

        $exists = $fileSystem->exists( $namedFile );

        if(!$hasFileToUpload) {
            throw new Exception('You need to set a file to Upload with setFileUpload method', 500);
        }

        if($exists) {
            throw new Exception('the Uploaded file already exist', 500);
        }

        $folder = $dt->toDateString();

        $sendToBdd = [
            'src' => $namedFile,
            'alt' => '',
            'folder' => $folder,
            'size' => (string) $fileUpload->getSize(),
            'mime_type' => $fileUpload->getMimeType(),
            'description' => '',
            'user_id' => user()->id,
        ];



        $fileSystem->putFileAs($folder, $fileUpload, $namedFile);

        $this->mediaRepository->addModel($this->model)->create($sendToBdd);
    }
    public function destroy() {
        $fileSystem = $this->getFileSystem();
        $config = $this->getConfig();
        $model = $this->getModel();

        if(empty($model)) {
            throw new Exception('You must define a Media Model :'.get_class($this), 500);
        }

        $url = $model->getRelativePath();
        $folderPath = $model->getFolderPath();

        // remove file
        $fileSystem->delete($url);

        $this->mediaRepository->addModel($model)->delete(null);

        $hasFiles = $fileSystem->files($folderPath);

        if(empty($hasFiles)) {
            $fileSystem->deleteDirectory($folderPath);
        }

    }
}
