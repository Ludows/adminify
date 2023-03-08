<?php

namespace Ludows\Adminify\Libs;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\SitemapIndex;

use Exception;

use Illuminate\Support\Facades\Schema;
class SitemapRender
{
    public function __construct()
    {
        $this->options = [];
        $this->app = app();
    }

    public function setOptions($array) {
        $this->options = array_merge($this->setDefaults(), is_array($array) ? $array : []);
        return $this;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setDefaults() {

        return [
            'models' => [],
            'isMulti' => get_site_key('multilang'),
            'modelName' => null,
            'currentLang' => lang(),
            'locales' => locales() // based on locale
        ];
    }

    public function langsExcludingCurrentLang($langs, $current) {
        return array_diff($langs, [$current]);
    }

    public function createUrl($model, $options = []) {
        $isMultilang = $options['isMulti'];
        $is_unfollowable = $model->seoWith('robots', false) === 'no-follow';
        
        if(!$model) {
            return false;
        }
        if($is_unfollowable) {
            return false;
        }

        $url = $model->getSitemapUrl();
        $urlGenerator = Url::create($url);
        $urlGenerator->setPriority($model->priority_sitemap);
        $urlGenerator->setChangeFrequency($model->freq_sitemap);

        if($isMultilang) {
            $alternates = $this->getAlternates($model, $options);
            foreach ($alternates as $locale => $url) {
                # code...
                $urlGenerator->addAlternate($url, $locale);
            }
        }

        $urlGenerator->setLastModificationDate($model->updated_at);

        if (Schema::hasColumn($model->getTable(), $model->media_key)) {

            // column exist
            $imageSources = $model->getSitemapImages();

            foreach ($imageSources as $imageSource) {
                $urlGenerator->addImage($imageSource->getFullPath(), $imageSource->alt);
            }
        
        }
        return $urlGenerator;
    } 
    public function getAlternates($model, $options = []) {
        $a = [];
        $app = app();
        
        foreach ($options['locales'] as $key => $locale) {
            # code...
            if($locale != $options['currentLang']) {
                $app->setLocale($locale);
                $url_alternate = $model->urlpath;
                if(!empty($url_alternate)) {
                    $a[$locale] = $url_alternate;
                }
            }
        }

        $app->setLocale($options['currentLang']);
        return $a;
    }
    public function createSitemap($modelName = '', $modelClass = '', $options = []) {
        $m = new $modelClass();
        $this->checkRequiredExtend($m);

        if($m->allowSitemap) {
            $single_sitemap = Sitemap::create(); 
            $isTranslatableModel = is_translatable_model($m);
            $isMultilang = $options['isMulti'];

            if($isTranslatableModel && (bool) $isMultilang) {
                $all = $m->lang($options['currentLang'])->get()->all();
            }
            else {
                $all = $m->all()->all();
            }

            foreach ($all as $modelObject) {
                # code...
                
                $url = $this->createUrl($modelObject, $options);
                if($url != false) {
                    $single_sitemap->add($url);
                }
            }

            $single_sitemap->writeToDisk('public', 'sitemap_'.$modelName.'.xml');
        }
        
    }
    public function create() {
        $options = $this->getOptions();

        foreach ($options['models'] as $modelName => $modelClass) {
            $this->checkRequiredTraits($modelName, $modelClass);
            $this->createSitemap($modelName, $modelClass, $options);
        }

        $this->createRootSitemap($options);
    }
    public function show() {
        $options = $this->getOptions();
        $hasKeys = array_keys($options['models']);
        $fileToBind = 'sitemap_index.xml';
        $storage = storage('public');
        if(count($hasKeys) > 0) {
            $fileToBind = 'sitemap_'. $hasKeys[0] .'.xml';
        }

        $fileExist = $storage->exists($fileToBind);

        if($fileExist) {
            return $storage->get($fileToBind);
        }
        else {
            abort('404');
        }
        
    }
    public function checkRequiredTraits($modelName = '', $modelClass = '') {
        $traits = class_uses_recursive($modelClass);

        if(!in_array('Ludows\Adminify\Traits\Sitemapable', $traits)) {
            throw new Exception($modelName.' must have the Ludows\Adminify\Traits\Sitemapable trait to work');
        }
    }
    public function checkRequiredExtend($model = null) {
        $isContentTypeModel = is_content_type_model($model);
        if(!$isContentTypeModel) {
            throw new Exception('Are you sure that '.$modelName.' extends of Ludows\Adminify\Models\ContentTypeModel ?');
        }
    }
    public function createRootSitemap($options = []) {
       $root = SitemapIndex::create();
       $m = new $modelClass();
       
       foreach ($options['models'] as $modelName => $modelClass) {
            if($m->allowSitemap) {
                $root->add('/sitemap_'.$modelName.'.xml');
            }
       }
       
       $root->writeToDisk('public', 'sitemap_index.xml');
    }


    public function render() {
 // create new sitemap object
        $sitemap = $this->sitemap;

        $options = $this->getOptions();
        $othersLangs = $this->langsExcludingCurrentLang($options['locales'], $options['currentLang']);
        $isMultilang = get_site_key('multilang');

        if($options['modelName'] == null && $options['writeFile'] == false) {
                $sitemap->setCache('laravel.sitemap', 5);
        }

        foreach ($options['models'] as $modelName => $modelClass) {
            # code...

            if($options['modelName'] != null && $options['writeFile'] == false) {
                $sitemap->setCache('laravel.sitemap.'.$options['modelName'], 5);
            }
            if (!$sitemap->isCached()) {

                $traits = class_uses_recursive($modelClass);

                if(!in_array('Ludows\Adminify\Traits\Sitemapable', $traits)) {
                    throw new Exception($modelName.' must have the Ludows\Adminify\Traits\Sitemapable trait to work');
                }

                $m = new $modelClass();

                $allowSitemap = $m->allowSitemap;
                $isTranslatableModel = is_translatable_model($m);
                $isContentTypeModel = is_content_type_model($m);
                // $isLinkableMediaModel = is_linkable_media_model($m);

                if(!$isContentTypeModel) {
                    throw new Exception('Are you sure that '.$modelName.' extends of Ludows\Adminify\Models\ContentTypeModel ?');
                }

                if($allowSitemap) {
                    if($isTranslatableModel && (bool) $isMultilang) {
                        $all = $m->lang($options['currentLang'])->get()->all();
                    }
                    else {
                        $all = $m->all()->all();
                    }

                    foreach ($all as $modelObject) {
                        # code...
                        //@to be continued
                        $translations = [];
                        $images = [];
                        // check translated pages..
                        if($isMultilang && $isTranslatableModel) {
                            foreach ($othersLangs as $l) {
                                # code...
                                $transations = $m->getTranslations();

                                foreach ($translations as $t) {
                                    # code...
                                    if(array_key_exists($l, $t)) {

                                        //get url according the locale setted for the loop.
                                        app()->setLocale($l);

                                        $translations[] = [
                                            'language' => $l,
                                            'url' => $modelObject->urlpath
                                        ];

                                        break;
                                    }
                                }
                            }
                            //restore the current locale
                            app()->setLocale($options['currentLang']);
                        }

                        if (Schema::hasColumn($modelObject->getTable(), $modelObject->media_key)) {

                            // column exist
                            $imageSources = $modelObject->getSitemapImages();

                            foreach ($imageSources as $imageSource) {
                                # code...
                                $pathable_media = $imageSource->path;
                                $pathInfo = pathinfo($pathable_media);
                                $imageInformations = [
                                    'url' => $pathable_media,
                                    'title' => $pathInfo['filename']
                                ];

                                if(!empty($imageSource->alt)) {
                                    $imageInformations['caption'] = $imageSource->alt;
                                }

                                $images[] = $imageInformations;

                            }
                        }


                        // if($isLinkableMediaModel) {
                        //     $media = $modelObject->media;
                        //     if($media != null) {
                        //         $pathInfo = pathinfo($media->path);
                        //         $imageInformations = [
                        //             'url' => $media->path,
                        //             'title' => $pathInfo['filename']
                        //         ];

                        //         if($media->alt && strlen($media->alt) > 0) {
                        //             $imageInformations['caption'] = $media->alt;
                        //         }

                        //         $images[] = $imageInformations;
                        //     }
                        // }

                        //$loc, $lastmod = null, $priority = null, $freq = null, $images = [], $title = null, $translations = [], $videos = [], $googlenews = [], $alternates = []
                        // $fullpath = $modelObject->urlpath;
                        // if($fullpath != null) {

                        //     if(!is_homepage($m) && $isUrlableModel) {
                        //         $path = $modelObject->urlpath;
                        //     }
                        //     else {
                        //         $path = $modelObject->{$modelObject->sitemapCallable};
                        //     }

                        //     if(is_homepage($m) && $isUrlableModel) {
                        //         $path = '/';
                        //     }

                        //     $sitemap->add($path, $modelObject->updated_at, '0.9', 'monthly', $images, $modelObject->sitemapTitle, $translations);
                        // }

                        $url = $modelObject->getSitemapUrl();
                        $sitemap->add($url, $modelObject->updated_at, $modelObject->priority_sitemap, $modelObject->freq_sitemap, $images, $modelObject->sitemapTitle, $translations, [], [], $translations);

                    }

                    if($options['writeFile'] && $options['modelName'] != null) {
                        $sitemap->store('xml', $modelName.'-sitemap');
                        // $this->info('the sitemap '. $modelName .'-sitemap.xml was generated');
                    }
                }
            }

        }

        //dd($sitemap);

        return $options['writeFile']  ? 0 : $sitemap->render('xml');
    }
}
