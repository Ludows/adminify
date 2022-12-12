<?php

namespace Ludows\Adminify\Libs;

use Exception;
use App\Adminify\Models\Pwa;

class PwaService {
    public function __construct() {
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
