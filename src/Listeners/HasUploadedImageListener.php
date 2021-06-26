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
    public function handle(ImageWasUploaded $event, MediaRepository $MediaRepository, FormBuilder $FormBuilder)
    {

        $request = request();

        if(!$request->fromMediaCreate != null) {

            $form = $FormBuilder->create(CreateMedia::class, [
                'method' => 'POST',
                'url' => route('medias.store')
            ]);

            $info = pathinfo($event->path());
            
            $form->title->setValue($info['basename']);

            $form->src->setValue($info['basename']);

            $MediaRepository->create($form, $request);
        }

        // dd($event);
        // Get te public path to the file and save it to the database
        // $publicFilePath = str_replace(public_path(), "", $event->path());
        // FilePath::create(['path' => $publicFilePath]);
    }
}