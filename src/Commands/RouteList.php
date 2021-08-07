<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Support\Facades\Route;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RouteList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generates Avalaibles routes of your application in js file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arrayOfRoutes = array();
        $routeCollection = Route::getRoutes()->get();

        foreach ($routeCollection as $route) {
            # code...
            $arrayRoute = array(
                'methods' => $route->methods,
                'url' => config('app.url') . '/' . $route->uri
            );
            $arrayOfRoutes[$route->getName()] = $arrayRoute;
        }

        $exists = Storage::disk('myuploads')->has('routes.js');

        $content = 'window.LaravelRoutes ='. json_encode($arrayOfRoutes);

        // dd($content);
        if(!$exists) {
            Storage::disk('myuploads')->put('routes.js', $content);
        }
        else {
            Storage::disk('myuploads')->delete('routes.js');
            Storage::disk('myuploads')->put('routes.js', $content);
        }
        $this->info('Routes are generated');
        return 0;
    }
}
