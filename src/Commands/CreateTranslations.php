<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Ludows\Adminify\Models\Translations as Traductions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

use File;


class CreateTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:translations {--front} {--back}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate your translations from the recorded table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function createTranslationsFromArray($rootFolder = '', $translations = []) {
        $a = (object) [];
        $keys = array_keys($translations);
        
        foreach ($keys as $key) {
            # code...
            $the_type = gettype( $translations[$key] );

            if($the_type == 'string') {
                $a->{$rootFolder.'.'.$key} = $translations[$key];
            }

            if($the_type == 'array') {
                $a = (object) array_merge(
                    (array) $a,
                    (array) $this->createTranslationsFromArray($rootFolder.'.'.$key, $translations[$key])
                );
            }
        }

        return $a;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $isFront = $this->option('front');
        $isBack = $this->option('back');

        // if($isFront && !$isBack) {
            $traductions = new Traductions();
            $configSite = config('site-settings');
            $locales = $configSite['supported_locales'];
            if($configSite['multilang'] == false) {
                $locales = [ config('app.locale') ];
            }
            foreach ($locales as $locale) {
                # code...
                if($configSite['multilang']) {
                    $trads_by_lang = $traductions::lang($locale)->get()->all();
                }
                else {
                    $trads_by_lang = $traductions->all();
                }

                $messages = (object) [];
                if(count($trads_by_lang) > 0) {
                    foreach ($trads_by_lang as $trad_by_lang) {
                        # code...
                        $messages->{$trad_by_lang->key} = $trad_by_lang->text;
                    }
                }

                $langPath = resource_path() . '/lang/'. $locale .'/';
                $files = File::files($langPath);

                foreach ($files as $file) {
                    # code...
                    $info = pathinfo($file);
                    $trads = require($file);

                    // dd($trads);
                    $trads = $this->createTranslationsFromArray($info['filename'], $trads);

                    $messages = (object) array_merge(
                        (array) $messages,
                        (array) $trads
                    );
                }



                $exists = Storage::disk('myuploads')->has('traductions-'. $locale .'.js');

                $content = '(function(){
                    window.messages_'. $locale .' = '. json_encode($messages, true) .'
                })()';

                if (Cache::has('website_translations_'.$locale)) {
                    //
                    Cache::forget('website_translations_'.$locale);
                }
                Cache::put('website_translations_'.$locale, json_encode($messages, true));



                if(!$exists) {
                    Storage::disk('myuploads')->put('traductions-'. $locale .'.js', $content);
                }
                else {
                    Storage::disk('myuploads')->delete('traductions-'. $locale .'.js');
                    Storage::disk('myuploads')->put('traductions-'. $locale .'.js', $content);
                }
                $this->info('Traductions '. $locale .' are generated');
            }
        // }

        // if($isBack && !$isFront) {

        // }



        return 'ok';
    }
}
