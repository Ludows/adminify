<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Libs\SitemapRender;
class SitemapController extends Controller
{
    public function index($sitemapPart = null, SitemapRender $sitemap) {

        $configSitemap = get_site_key('sitemap');

        $classCheck = null;
        if($sitemapPart != null && array_key_exists($sitemapPart, $configSitemap)) {
            $classCheck = adminify_get_class($configSitemap[$sitemapPart], ['app:adminify:models', 'app:models'], false);
        }
        else if($sitemapPart == null) {
            $classCheck = $configSitemap;
            $i = 0;
            foreach ($classCheck as $cls) {
                # code...
                $classCheck[$i] = adminify_get_class($cls, ['app:adminify:models', 'app:models'], false);
                $i++;
            }
        }

        if($classCheck == null) {
            abort('404');
        }

        $params = [
            'writeFile' => false,
            'modelName' => $sitemapPart ?? null,
            'models' => is_array($classCheck) ? $classCheck : [$sitemapPart => $classCheck],
            'currentLang' => lang(),
            'locales' => locales()
        ];

        $sitemap->setOptions($params);

        return $sitemap->render();

    }
}
