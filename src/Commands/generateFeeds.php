<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Ludows\Adminify\Models\Translations as Traductions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

use File;


class generateFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:feeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate feeds config';

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

        $feeds = get_site_key('feeds');
        $array = [
            'main' => [
                'items' => ['App\Feeds\Site', 'all'],

                'url' => '/feeds',

                'title' => 'Datas from website !',

                /*
                * The format of the feed.  Acceptable values are 'rss', 'atom', or 'json'.
                */
                'format' => 'rss',
                
                /*
                * Custom view for the items.
                *
                * Defaults to feed::feed if not present.
                */
                // 'view' => 'feed::feed',
            ]
        ];

        foreach ($feeds['hydrate'] as $feedableKey) {
            # code...
            $array[$feedableKey] = [
                /*
                 * Here you can specify which class and method will return
                 * the items that should appear in the feed. For example:
                 * [App\Model::class, 'getAllFeedItems']
                 *
                 * You can also pass an argument to that method.  Note that their key must be the name of the parameter:             *
                 * [App\Model::class, 'getAllFeedItems', 'parameterName' => 'argument']
                 */
                'items' => ['App\Feeds\Site', $feedableKey],
    
                /*
                 * The feed will be available on this url.
                 */
                'url' => '/feed/'. $feedableKey .'',
    
                'title' => str_replace('##DATA##', $feedableKey, $feeds['trad']['title']),
                'description' => str_replace('##DATA##', $feedableKey, $feeds['trad']['description']),
                'language' => lang(),
    
                /*
                 * The image to display for the feed.  For Atom feeds, this is displayed as
                 * a banner/logo; for RSS and JSON feeds, it's displayed as an icon.
                 * An empty value omits the image attribute from the feed.
                 */
                'image' => '',
    
                /*
                 * The format of the feed.  Acceptable values are 'rss', 'atom', or 'json'.
                 */
                'format' => 'rss',
    
                /*
                 * The view that will render the feed.
                 */
                // 'view' => 'feed::feed',
    
                /*
                 * The mime type to be used in the <link> tag.  Set to an empty string to automatically
                 * determine the correct value.
                 */
                'type' => '',
    
                /*
                 * The content type for the feed response.  Set to an empty string to automatically
                 * determine the correct value.
                 */
                'contentType' => '',
            ];
        }

        // config(['feed' => $feeds]);
        File::put(config_path('feed.php'), $feeds);
        
        return 'ok';
    }
}
