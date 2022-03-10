<?php
namespace Ludows\Adminify\Listeners;

use Unisharp\Laravelfilemanager\Events\ImageWasUploaded;
use App\Adminify\Repositories\MediaRepository;
use App\Adminify\Models\Media;
class HasUploadedImageListener
{
    /**
     * Handle the event.
     *
     * @param  ImageWasUploaded  $event
     * @return void
     */
    public function __construct(MediaRepository $MediaRepository) {
        $this->MediaRepository = $MediaRepository;
    }
    public function handle(ImageWasUploaded $event)
    {

        $request = request();
        $fromCreate = $request->input('fromMediaCreate', 0);

        if($fromCreate == 0) {

            
            $info = pathinfo($event->path());
            
            $a = [
                'src' => $info['basename'],
                'description' => '',
                'alt' => '',
                'user_id' => user()->id
            ];

            $this->MediaRepository->addModel(new Media())->create($a);
        }

        // dd($event);
        // Get te public path to the file and save it to the database
        // $publicFilePath = str_replace(public_path(), "", $event->path());
        // FilePath::create(['path' => $publicFilePath]);
    }
}