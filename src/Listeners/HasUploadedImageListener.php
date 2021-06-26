<?php
namespace Ludows\Adminify\Listeners;

use Unisharp\Laravelfilemanager\Events\ImageWasUploaded;
use Ludows\Adminify\Repositories\MediaRepository;
use Ludows\Adminify\Forms\CreateMedia;
use Kris\LaravelFormBuilder\FormBuilder;
class HasUploadedImageListener
{
    /**
     * Handle the event.
     *
     * @param  ImageWasUploaded  $event
     * @return void
     */
    public function __construct(MediaRepository $MediaRepository, FormBuilder $FormBuilder) {
        $this->MediaRepository = $MediaRepository;
        $this->FormBuilder = $FormBuilder;
    }
    public function handle(ImageWasUploaded $event)
    {

        $request = request();

        if(!$request->fromMediaCreate != null) {

            $form = $this->FormBuilder->create(CreateMedia::class, [
                'method' => 'POST',
                'url' => route('medias.store')
            ]);

            $info = pathinfo($event->path());
            
            $form->title->setValue($info['basename']);

            $form->src->setValue($info['basename']);

            $this->MediaRepository->create($form, $request);
        }

        // dd($event);
        // Get te public path to the file and save it to the database
        // $publicFilePath = str_replace(public_path(), "", $event->path());
        // FilePath::create(['path' => $publicFilePath]);
    }
}