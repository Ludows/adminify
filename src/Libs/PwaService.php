<?php

namespace Ludows\Adminify\Libs;

use Exception;
use App\Adminify\Models\Pwa;
use App\Adminify\Models\Media;
// use App\Adminify\Models\Pwa;


class PwaService {
    public function __construct() {
        $this->uuid = $this->getPrefix().uuid(15);
    }
    public function getPrefix() {
        return 'sw-';
    }
    public function generateIcons() {
        $m = new Pwa();
        $pwa_config = get_site_key('pwa');
        $icon = $m->getSetting('icon');

        if(empty($icon->data)) {
            // as fallback if not icon is provided.
            $icon = $m->getGlobalSetting('logo_id')->data ?? null;
        }


        if(!empty($icon->data)) {
            $media = media( (int) $icon->data );
            // $glide = glide();
            $icons = [];
            if(!empty($pwa_config['dimensions'])) {
                $url = $media->getRelativePath();
                foreach ($pwa_config['dimensions'] as $key => $dimension) {
                    # code...
                    $img = image($url , $dimension);
                    $t = [
                        'src' => $img,
                        'size' => $dimension['w'].'x'.$dimension['h'],
                        'type' => $media->mime_type
                    ];

                    $icons[] = $t;
                }

                // on enregistre en db;
                $existSetting = $m->settingExists('icons');
                if(!$existSetting) {
                    $m->createSetting('icons', $icons);
                }
                else {
                    $m->updateSetting('icons', $icons);
                }
            }
        }
    }
    public function generateSw() {

        $m = new Pwa();

        $configSite = config('site-settings');
        $locales = $configSite['supported_locales'];
        $isMultilang = $configSite['multilang'];
        $files = [];
        if($isMultilang == false) {
            $locales = [ config('app.locale') ];
        }

        $content_types = get_content_types();

        $jsQuery = $m->getSetting('js');
        $cssQuery = $m->getSetting('css');
        $additionnalsImgs = $m->getSetting('images');

        $allJs = empty($jsQuery->data) ? [] : explode(',', $jsQuery->data);
        $allCss = empty($cssQuery->data) ? [] : explode(',', $cssQuery->data);
        $allMedias = Media::all()->all();
        $addImgs = empty($additionnalsImgs->data) ? [] : explode(',', $additionnalsImgs->data);

        $offlinePage = $m->getGlobalSetting('offline_page');
        $offline_urls = [];

        if($content_types['Page']) {
            if(!empty($offlinePage->data)) {
                $page = new $content_types['Page'];
                foreach ($locales as $key => $locale) {

                    if($isMultilang) {
                        $page = $page->where('id', (int) $offlinePage->data )->withStatus( status()::PUBLISHED_ID )->lang($locale)->get();
                    }
                    else {
                        $page = $page->where('id', (int) $offlinePage->data )->withStatus( status()::PUBLISHED_ID )->get();
                    }

                    if($page->isNotEmpty()) {
                        $offline_urls[$locale] = $page->first()->urlpath;
                    }

                }
            }
        }

        $files = array_merge($files, $allJs, $allCss, $addImgs);

        foreach ($allMedias as $keyedNameModel => $media) {
            $files[] = $media->getRelativePath();
        }

        
        foreach ($content_types as $keyedNameModel => $model) {
            $currentModel = new $model;
            if($currentModel->allowSitemap) {
                foreach ($locales as $key => $locale) {
                    # code...
                    if($isMultilang) {
                        $allPublished = $currentModel->withStatus( status()::PUBLISHED_ID )->lang($locale)->get();
                    }
                    else {
                        $allPublished = $currentModel->withStatus( status()::PUBLISHED_ID )->get();
                    }

                    foreach ($allPublished as $key => $localBoundedModel) {
                        $files[] = $localBoundedModel->urlpath;
                    }
                }
            }
        }

        return "
        // This file is auto generated. Please don't try to modify them.
        var staticCacheName = '". $this->uuid ."';
        var filesToCache = ". json_encode($files) .";
        
        // Cache on install
        self.addEventListener('install', event => {
            this.skipWaiting();
            event.waitUntil(
                caches.open(staticCacheName)
                    .then(cache => {
                        return cache.addAll(filesToCache);
                    })
            )
        });
        
        // Clear cache on activate
        self.addEventListener('activate', event => {
            event.waitUntil(
                caches.keys().then(cacheNames => {
                    return Promise.all(
                        cacheNames
                            .filter(cacheName => (cacheName.startsWith('". $this->getPrefix() ."')))
                            .filter(cacheName => (cacheName !== staticCacheName))
                            .map(cacheName => caches.delete(cacheName))
                    );
                })
            );
        });
        
        // Serve from Cache
        self.addEventListener('fetch', event => {
            event.respondWith(
                caches.match(event.request)
                    .then(response => {
                        return response || fetch(event.request);
                    })
                    .catch(() => {

                        var offline_urls = ". json_encode($offline_urls) .";
                        // var offline_keys = Object
                        var lang = document.documentElement.getAttribute('lang');

                        if(offline_urls[lang]) {
                            return caches.match( offline_urls[lang] );
                        }
                    })
            )
        });";
    }
    public function renderManifest() {

        $m = new Pwa();

        $icons = $m->getSetting('icons');

        $ret = [
            "name" => $m->getSetting('name')->data ?? env('APP_NAME'),
            "start_url" => url('/') ?? env('APP_URL'),
            "display" => $m->getSetting('display')->data ?? 'standalone',
            "lang" => lang() ?? 'fr-FR',
            "short_name" => $m->getSetting('shortname')->data ?? env('APP_NAME'),
            "description" => $m->getSetting('description')->data ?? '',
            "theme_color" => $m->getSetting('theme_color')->data ?? '',
            "background_color" => $m->getSetting('background_color')->data ?? '',
            "orientation" => $m->getSetting('orientation')->data ?? 'portrait',
            "icons" => !empty($icons) ? json_decode($icons->data) : [],
        ];

        return $ret;
    }
}
