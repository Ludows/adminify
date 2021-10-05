<?php

namespace Ludows\Adminify\Libs;

class SitemapRender
{
    public function __construct()
    {
        $this->sitemap = app()->make("sitemap");
        $this->options = [];
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
            'modelName' => null,
            'writeFile' => false,
            'currentLang' => config('app.locale'),
            'locales' => config('site-settings.supported_locales') // based on locale
        ];
    }

    public function langsExcludingCurrentLang($langs, $current) {
        return array_diff($langs, [$current]);
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
                $m = new $modelClass();
                $allowSitemap = $m->allowSitemap;
                $isTranslatableModel = is_translatable_model($m);
                $isUrlableModel = is_urlable_model($m);
                $isLinkableMediaModel = is_linkable_media_model($m);


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
                                $t = $m->getTranslations();
                                if(array_key_exists($l, $t)) {
                                    $translations[] = [
                                        'language' => $l,
                                        'url' => $modelObject->urlpath
                                    ];
                                }

                            }
                        }


                        if($isLinkableMediaModel) {
                            $media = $modelObject->media;
                            if($media != null) {
                                $pathInfo = pathinfo($media->path);
                                $imageInformations = [
                                    'url' => $media->path,
                                    'title' => $pathInfo['filename']
                                ];

                                if($media->alt && strlen($media->alt) > 0) {
                                    $imageInformations['caption'] = $media->alt;
                                }

                                $images[] = $imageInformations;
                            }
                        }

                        //$loc, $lastmod = null, $priority = null, $freq = null, $images = [], $title = null, $translations = [], $videos = [], $googlenews = [], $alternates = []
                        $fullpath = $modelObject->urlpath;
                        if($fullpath != null) {

                            if(!is_homepage($m) && $isUrlableModel) {
                                $path = $modelObject->urlpath;
                            }
                            else {
                                $path = $modelObject->{$modelObject->sitemapCallable};
                            }

                            if(is_homepage($m) && $isUrlableModel) {
                                $path = '/';
                            }

                            $sitemap->add($path, $modelObject->updated_at, '0.9', 'monthly', $images, $modelObject->sitemapTitle, $translations);
                        }
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
