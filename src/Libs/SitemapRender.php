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
            $suffixMulti = '';

            if($isTranslatableModel && (bool) $isMultilang) {
                $all = $m->lang($options['currentLang'])->get()->all();
                $suffixMulti = '_'.$options['currentLang'];
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


            $single_sitemap->writeToDisk('public', '/sitemap_'.$modelName.$suffixMulti.'.xml');
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
        $storage = storage('public');
        $suffixMulti = '';

        if($options['isMulti']) {
            $suffixMulti = '_'.$options['currentLang'];
        }

        $fileToBind = 'sitemap_index'. $suffixMulti .'.xml';

        if(count($hasKeys) > 0) {
            $fileToBind = 'sitemap_'. lowercase( plural( $hasKeys[0] ) ) .$suffixMulti.'.xml';
        }

        $fileExist = $storage->exists($fileToBind);

        if($fileExist) {
            return $storage->get($fileToBind);
        }
        else {
            return null;
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
            throw new Exception('Are you sure that the current model extends of Ludows\Adminify\Models\ContentTypeModel ?');
        }
    }
    public function createRootSitemap($options = []) {
       $root = SitemapIndex::create();

       $suffixMulti = '';

        if($options['isMulti']) {
            $suffixMulti = '_'.$options['currentLang'];
        }

        $fileToBind = 'sitemap_index'. $suffixMulti .'.xml';
       
       foreach ($options['models'] as $modelName => $modelClass) {
            $m = new $modelClass();
            if($m->allowSitemap) {
                $root->add('/sitemap_'.$modelName.$suffixMulti.'.xml');
            }
       }
       
       $root->writeToDisk('public', '/'.$fileToBind);
    }
}
