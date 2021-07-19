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
        if($slug != null) {
            $classCheck = $configSitemap[$slug];
        }
        else {
            $classCheck = $configSitemap;
        }

        if($classCheck == null) {
            abort('404');
        }

        $params = [
            'writeFile' => false,
            'models' => is_array($classCheck) ? $classCheck : [$slug => $classCheck]
        ];

        $output = new BufferedOutput;

        Artisan::call('generate:sitemap', $params, $output);

        return $output->fetch();

    }
}
