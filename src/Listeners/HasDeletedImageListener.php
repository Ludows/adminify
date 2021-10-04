<?php
namespace Ludows\Adminify\Listeners;

use Unisharp\Laravelfilemanager\Events\ImageWasDeleted;
use App\Adminify\Repositories\MediaRepository;
use App\Adminify\Models\Media;

class HasDeletedImageListener
{
    /**
     * Handle the event.
     *
     * @param  ImageWasUploaded  $event
     * @return void
     */
    public function handle(ImageWasDeleted $event)
    {

        $info = pathinfo($event->path());

        $media = Media::where('src', $info['basename']);

        if($media != null) {
            $media->delete();
        }
        
        // Get te public path to the file and save it to the database
        // $publicFilePath = str_replace(public_path(), "", $event->path());
        // FilePath::create(['path' => $publicFilePath]);
    }
}