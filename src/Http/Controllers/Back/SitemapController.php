<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;

use Illuminate\Support\Facades\Artisan;

use Symfony\Component\Console\Output\BufferedOutput;

class SitemapController extends Controller
{
    public function index(Request $request) {

        $slug = $request->slug;
        $configSitemap = get_site_key('sitemap');
        $classCheck = $configSitemap[$slug];

        $params = [
            'show' => true,
        ];

        if($slug == null) {

        }

        if($classCheck != null && $slug != null) {
            $params['model'] = $classCheck;
        }

        $output = new BufferedOutput;

        Artisan::call('sitemap', $params, $output);

        return $output->fetch();

    }
}
