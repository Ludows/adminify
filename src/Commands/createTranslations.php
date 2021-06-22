<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use App\Models\Traduction as Traductions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;


class createTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:translations {--front} {--back}';

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $isFront = $this->option('front');
        $isBack = $this->option('back');

        if($isFront && !$isBack) {
            $traductions = new Traductions();
            $configSite = config('site-settings');
            $locales = config('laravel-gettext.supported-locales');
            if($configSite['multilang'] == false) {
                $locales = ['fr'];
            }
            foreach ($locales as $locale) {
                # code...
                if($configSite['multilang']) {
                    $trads_by_lang = $traductions::lang($locale)->all();
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

                $exists = Storage::disk('myuploads')->has('traductions-'. $locale .'.js');

                $content = '(function(){
                    var messages_'. $locale .' = '. json_encode($messages, true) .'

                    window.__ = createLaravelLocalization(messages_'. $locale .');
                })()';

                if (Cache::has('translations_front')) {
                    //
                    Cache::forget('translations_front');
                }
                Cache::put('translations_front', json_encode($messages, true));



                if(!$exists) {
                    Storage::disk('myuploads')->put('traductions-'. $locale .'.js', $content);
                }
                else {
                    Storage::disk('myuploads')->delete('traductions-'. $locale .'.js');
                    Storage::disk('myuploads')->put('traductions-'. $locale .'.js', $content);
                }
                $this->info('Traductions '. $locale .' are generated');
            }
        }

        if($isBack && !$isFront) {

        }



        return 'ok';
    }
}
