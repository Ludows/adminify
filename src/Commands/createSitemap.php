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
    protected $signature = 'generate:sitemap 
        {writeFile : Tell if you write the sitemap generated on the disk} 
        {models : Array of models for your sitemap generation}';

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
    public function setDefaults() {
        $sitemap = get_site_key('sitemap');

        return [
            'models' => array_merge([], $sitemap),
            'writeFile' => false,
        ];
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
        

        $options = array_merge($this->setDefaults(), $this->options() ?? []);

        foreach ($options['models'] as $modelName => $modelClass) {
            # code...
            $model = get_site_key( $modelClass );
            $m = new $model();
            $all = $m->all();
            dump($all);

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
