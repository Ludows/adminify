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
    public function getKeyedFrontAttribute($model, $key) {
        return $model->getKeyFrontAttribute($key);
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
                    $isSearch = is_search($localBoundedModel);
                    if($isHome) {
                        $baseMethod = $this->config['methods']['homepage'];
                        $url = '/';
                    }
                    
                    $strFile .= "Route::get( '". $url . "','".$this->config['handle'].'@'.$baseMethod."')->name('frontend.". lowercase($keyedNameModel) .".". str_replace('-', '_', $localBoundedModel->slug) ."');";
                    
                    if($isSearch) {
                        $baseMethod = $this->config['methods']['search'];
                        // $router->post('/search', 'App\Adminify\Http\Controllers\Front\PageController@search')->name('globalsearch');
                        $strFile .= "Route::post( '". $url . "','".$this->config['handle'].'@'.$baseMethod."')->name('globalsearch');";
                    }
                    
                    // "Route::get( $localBoundedModel->ur , 'App\Adminify\Http\Controllers\Front\PageController@index')->name('pages.front.index');"
                }

                if($currentModel->shouldUseCategory()) {

                    $category_key_route_path = $currentModel->getKeyFrontAttribute('category', lang());

                    $baseMethod = $this->config['methods']['categories'];

                    $strFile .= "Route::get( '/". lowercase($keyedNameModel) ."/". $category_key_route_path ."/','".$this->config['handle'].'@'.$baseMethod."')->name('frontend.". lowercase($keyedNameModel) .".categories.root');";

                    $baseMethod = $this->config['methods']['category'];
                    $strFile .= "Route::get( '/". lowercase($keyedNameModel) ."/". $category_key_route_path ."/{category}','".$this->config['handle'].'@'.$baseMethod."')->name('frontend.". lowercase($keyedNameModel) .".category');";
                }
                if($currentModel->shouldUseArchive()) {
                    $archive_key_route_path = $currentModel->getKeyFrontAttribute('archive', lang());

                    $baseMethod = $this->config['methods']['archives'];

                    $strFile .= "Route::get( '/". lowercase($keyedNameModel) ."/". $archive_key_route_path ."/','".$this->config['handle'].'@'.$baseMethod."')->name('frontend.". lowercase($keyedNameModel) .".archive.root');";

                }
                if($currentModel->shouldUseTag()) {
                    $tags_key_route_path = $currentModel->getKeyFrontAttribute('tag', lang());

                    $baseMethod = $this->config['methods']['tags'];

                    $strFile .= "Route::get( '/". lowercase($keyedNameModel) ."/". $tags_key_route_path ."/','".$this->config['handle'].'@'.$baseMethod."')->name('frontend.". lowercase($keyedNameModel) .".tags.root');";

                    $baseMethod = $this->config['methods']['category'];
                    $strFile .= "Route::get( '/". lowercase($keyedNameModel) ."/". $category_key_route_path ."/{tag}','".$this->config['handle'].'@'.$baseMethod."')->name('frontend.". lowercase($keyedNameModel) .".tag');";
                }

            }
        }

        
        return $strFile;
    }
    private function getStringTemplate() {
        return '<?php
        use Illuminate\Support\Facades\Route;';
    }
    public function getRoutesPath() {
        return $this->config['appendTo'];
    }
    public function getFileNameRoute() {
        return $this->config['file_routes'];
    }
    public function getRoutes() {
        $ret = [];
        $routesPath = $this->getRoutesPath();
        $fileNameRoute = $this->getFileNameRoute();

        $configSite = config('site-settings');
        $locales = $configSite['supported_locales'];

        $isMultilang = $configSite['multilang'];
        if($isMultilang == false) {
            $locales = [ config('app.locale') ];
        }

        foreach ($locales as $key => $locale) {
            
            $pathFile = $this->config['appendTo'].$locale.'_'.$this->config['file_routes'];

            if(File::exists( $pathFile )) {
                $ret[] = $pathFile;
            }
        }

    
        return $ret;
    }
}
