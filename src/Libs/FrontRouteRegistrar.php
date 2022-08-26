<?php

namespace Ludows\Adminify\Libs;

use Error;
use File;

class FrontRouteRegistrar {
    public function __construct() {
        $this->registrarModels = get_content_types();
        $this->request = request();
        $this->config = get_site_key('front');
    }
    public function generate() {
        $strFile = $this->getStringTemplate();

        foreach ($this->registrarModels as $keyedNameModel => $model) {
            # code...
            $currentModel = new $model;
            if($currentModel->allowSitemap) {
                $allPublished = $currentModel->withStatus( status()::PUBLISHED_ID )->get();

                foreach ($allPublished as $key => $localBoundedModel) {
                    # code...
                    $baseMethod = $this->config['methods']['pages'];
                    $url = join('/', $localBoundedModel->url);
                    $isHome = is_homepage($localBoundedModel);
                    if($isHome) {
                        $baseMethod = $this->config['methods']['homepage'];
                        $url = '/';
                    }

                    $strFile .= "Route::get( '". $url . "','".$this->config['handle'].'@'.$baseMethod."')->name('frontend.". lowercase($keyedNameModel) .".". str_replace('-', '_', $localBoundedModel->slug) ."');";
                    // "Route::get( $localBoundedModel->ur , 'App\Adminify\Http\Controllers\Front\PageController@index')->name('pages.front.index');"
                }

            }
        }

        $pathFile = $this->config['appendTo'].$this->config['file_routes'];


        if(File::exists( $pathFile )) {
            File::replace($pathFile, $strFile);
        }
        else {
            File::put($pathFile, $strFile);
        }

    }
    private function getStringTemplate() {
        return '<?php
        use Illuminate\Support\Facades\Route;';
    }
    public function getRoutes() {
        $ret = null;
        $pathFile = $this->config['appendTo'].$this->config['file_routes'];
        if(File::exists( $pathFile )) {
            $ret = $pathFile;
        }
        return $ret;
    }
}
