<?php
namespace Ludows\Adminify\Listeners;

use Unisharp\Laravelfilemanager\Events\ImageWasRenamed;
use Ludows\Adminify\Repositories\MediaRepository;
use Ludows\Adminify\Forms\UpdateMedia;
use Ludows\Adminify\Models\Media;
use Kris\LaravelFormBuilder\FormBuilder;
class HasRenamedImageListener
{
    /**
     * Handle the event.
     *
     * @param  ImageWasRenamed  $event
     * @return void
     */
    public function handle(ImageWasRenamed $event, MediaRepository $MediaRepository, FormBuilder $FormBuilder)
    {

        $request = request();

        if(!$request->fromMediaCreate) {

            $form = $FormBuilder->create(UpdateMedia::class, [
                'method' => 'POST',
                'url' => route('medias.update')
            ]);

            $info = pathinfo($event->oldPath());
            $newInfo = pathinfo($event->newPath());

            $m = Media::where('src', $info['basename']);

            $form->title->setValue($m->title);

            $form->src->setValue($newInfo['basename']);

            $MediaRepository->update($form, $request, $m);
        }

        // dd($event);
        // Get te public path to the file and save it to the database
        // $publicFilePath = str_replace(public_path(), "", $event->path());
        // FilePath::create(['path' => $publicFilePath]);
    }
}