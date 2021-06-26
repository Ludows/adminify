<?php
namespace Ludows\Adminify\Listeners;

use Unisharp\Laravelfilemanager\Events\ImageWasRenamed;
use Ludows\Adminify\Repositories\MediaRepository;
use Ludows\Adminify\Models\Media;
class HasRenamedImageListener
{
    /**
     * Handle the event.
     *
     * @param  ImageWasRenamed  $event
     * @return void
     */
    public function __construct(MediaRepository $MediaRepository) {
        $this->MediaRepository = $MediaRepository;
    }
    public function handle(ImageWasRenamed $event)
    {

        $request = request();

        if(!$request->fromMediaCreate != null) {

            $info = pathinfo($event->oldPath());
            $newInfo = pathinfo($event->newPath());

            $m = Media::where('src', $info['basename']);

            $a = [
                'title' => $m->title,
                'src' => $newInfo['basename'],
            ];

            $this->MediaRepository->update($a, $request, $m);
        }

        // dd($event);
        // Get te public path to the file and save it to the database
        // $publicFilePath = str_replace(public_path(), "", $event->path());
        // FilePath::create(['path' => $publicFilePath]);
    }
}