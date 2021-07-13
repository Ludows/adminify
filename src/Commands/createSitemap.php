<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Ludows\Adminify\Models\Translations as Traductions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;


class createSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate your sitemap';

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

        // create new sitemap object
        $sitemap = app()->make("sitemap");
        $config = config('site-settings');

        foreach ($config['sitemap'] as $model) {
            # code...

            $m = new $model();
            $all = $m->all();

            foreach ($all as $modelData) {
                # code...
                //@to be continued
                if($config['multilang']) {

                }
                else {

                }
            }

        }



        return 'ok';
    }
}
