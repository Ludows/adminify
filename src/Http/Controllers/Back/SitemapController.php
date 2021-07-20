<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Libs\SitemapRender;

class SitemapController extends Controller
{
    public function index($sitemapPart = null) {

        $configSitemap = get_site_key('sitemap');

        $classCheck = null;
        if($sitemapPart != null && array_key_exists($sitemapPart, $configSitemap)) {
            $classCheck = $configSitemap[$sitemapPart];
        }
        else if($sitemapPart == null) {
            $classCheck = $configSitemap;
        }

        if($classCheck == null) {
            abort('404');
        }

        $params = [
            'writeFile' => false,
            'modelName' => $sitemapPart ?? null,
            'models' => is_array($classCheck) ? $classCheck : [$sitemapPart => $classCheck],
            'currentLang' => config('app.locale'),
            'locales' => config('site-settings.supported_locales')
        ];

        $sitemap = new SitemapRender();
        $sitemap->setOptions($params);

        return $sitemap->render();

    }
}
