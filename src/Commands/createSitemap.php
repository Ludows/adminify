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
        {models : Array of models for your sitemap generation}
        {currentLang : You can tell currentLang. it is used for multilang}
        {locales : You can tell your locale list. it is used for multilang}';

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
            'currentLang' => config('app.locale'),
            'locales' => config('site-settings.supported_locales') // based on locale
        ];
    }
    public function langsExcludingCurrentLang($langs, $current) {
        return array_diff($langs, [$current]);
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
        $othersLangs = $this->langsExcludingCurrentLang($options['locales'], $options['currentLang']);
        //dd($options, $othersLangs);

        foreach ($options['models'] as $modelName => $modelClass) {
            # code...
            $model = get_site_key( $modelClass );
            $m = new $model();
            $isTranslatableModel = is_translatable_model($m);
            $isUrlableModel = is_urlable_model($m);
            $isMultilang = get_site_key('multilang');


                if($isTranslatableModel) {
                    $all = $m->lang($options['currentLang'])->get()->all();
                }
                else {
                    $all = $m->all()->all();
                }


                dump($all);


                foreach ($all as $modelObject) {
                    # code...
                    //@to be continued
                    $translations = [];
                    if($isMultilang) {
                        foreach ($othersLangs as $l) {
                            # code...
                            // $t = $m->getTranslation();
                        }
                    }

                }



        }



        return 'ok';
    }
}
