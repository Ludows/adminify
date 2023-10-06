<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

use Ludows\Adminify\Libs\SitemapRender;
class SitemapController extends Controller
{
    public function showIndexPage(Request $request, SitemapRender $sitemap) {

       $part = $request->part ?? '';
       $content_types = get_content_types();
       $keys = array_keys($content_types);

       if(!in_array($part, $keys)) {
         $part = titled( singular($part) );
       }
        
       $classCheck = null;
        if(!empty($part)) {
            $classCheck = adminify_get_class($part, ['app:adminify:models', 'app:models'], false);
        }
        
        $params = [
            'modelName' => $part ?? null,
            'models' => empty($part) ? [] : [$part => $classCheck],
            'currentLang' => lang(),
            'locales' => locales()
        ];

        $sitemap->setOptions($params);

        $show = $sitemap->show();
        
        if(empty($show)) {
            abort('404');
        }
        else {
            return Response::make($show, 200, [
                'Content-Type' => 'text/xml',
            ]);
        }

        

    }
}
