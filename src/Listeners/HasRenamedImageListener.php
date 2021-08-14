<?php
namespace Ludows\Adminify\Listeners;

use Unisharp\Laravelfilemanager\Events\ImageWasRenamed;
use App\Repositories\MediaRepository;
use App\Models\Media;
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

        if(!$request->fromMediaCreate) {

            $info = pathinfo($event->oldPath());
            $newInfo = pathinfo($event->newPath());

            $m = Media::where('src', $info['basename']);

            $a = [
                'src' => $newInfo['basename'],
            ];

            $this->MediaRepository->addModel($m)->update($a, $m);
        }

        // dd($event);
        // Get te public path to the file and save it to the database
        // $publicFilePath = str_replace(public_path(), "", $event->path());
        // FilePath::create(['path' => $publicFilePath]);
    }
}