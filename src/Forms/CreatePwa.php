<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;
use App\Adminify\Models\Pwa;

class CreatePwa extends BaseForm
{
    public function buildForm()
    {
        // $m = $this->getModel();
        $m = new Pwa();
        // dd($m->getSetting('name'));
        $nameSetting = $m->getSetting('name');
        $shortnameSetting = $m->getSetting('shortname');
        $descriptionSetting = $m->getSetting('description');
        $theme_colorSetting = $m->getSetting('theme_color');
        $status_barSetting = $m->getSetting('status_bar');
        $background_colorSetting = $m->getSetting('background_color');
        $orientationSetting = $m->getSetting('orientation');
        $displaySetting = $m->getSetting('display');
        $iconSetting = $m->getSetting('icon');
        $globalLogo_id= $m->getGlobalSetting('logo_id');
        $cssSettings = $m->getSetting('css');
        $jsSettings = $m->getSetting('js');
        $imagesSettings = $m->getSetting('images');

        $this->add('uuid', 'hidden', [
            "value" => 'sw-'.uuid(15)
        ]);

       $this->add('name', 'text', [
            "label" => strip_tags( translate('adminify.pwa.name') ),
            "value" => empty($nameSetting) ? $m->getGlobalSetting('site_name')->data : $nameSetting->data,
       ]);

       $this->add('shortname', 'text', [
            "label" => strip_tags( translate('adminify.pwa.shortname') ),
            "attr" => [
                'maxlength' => 12,
            ],
            "value" => empty($shortnameSetting) ? '' : $shortnameSetting->data,
        ]);

        $this->addJodit('description', [
            "label" => strip_tags( translate('adminify.pwa.description') ),
            "value" => empty($descriptionSetting) ? $m->getGlobalSetting('slogan') : $descriptionSetting->data,
        ]);

        $this->addMediaLibraryPicker('icon', [
            "label" => strip_tags( translate('adminify.pwa.icon') ),
            'value' => !empty($iconSetting) ? $iconSetting->data : $globalLogo_id?->data,
        ]);
        

        $this->add('status_bar', 'color', [
            "label" => strip_tags( translate('adminify.pwa.status_bar') ),
            "value" => empty($status_barSetting) ? '' : $status_barSetting->data,
        ]);

        $this->add('theme_color', 'color', [
            "label" => strip_tags( translate('adminify.pwa.theme_color') ),
            "value" => empty($theme_colorSetting) ? '' : $theme_colorSetting->data,
        ]);

        $this->add('background_color', 'color', [
            "label" => strip_tags( translate('adminify.pwa.background_color') ),
            "value" => empty($background_colorSetting) ? '' : $background_colorSetting->data,
        ]);

        $this->addSelect2('display', [
            "label" => strip_tags( translate('adminify.pwa.display') ),
            "select2options" => [
                "multiple" => false
            ],
            "choices" => [
                'fullscreen' => strip_tags( translate('adminify.display.fullscreen') ),
                'standalone' => strip_tags( translate('adminify.display.standalone') ),
                'minimal-ui' => strip_tags( translate('adminify.display.minimal-ui') ),
            ],
            "selected" => empty($displaySetting) ? 'fullscreen' : $displaySetting->data,
        ]);

        $this->addSelect2('orientation', [
            "label" => strip_tags( translate('adminify.pwa.orientation') ),
            "select2options" => [
                "multiple" => false
            ],
            "choices" => [
                'any' => strip_tags( translate('adminify.orientation.any') ),
                'landscape' => strip_tags( translate('adminify.orientation.landscape') ),
                'portrait' => strip_tags( translate('adminify.orientation.portrait') ),
            ],
            "selected" => empty($orientationSetting) ? 'portrait' : $orientationSetting->data,
        ]);

        $this->add('images', 'textarea', [
            "label" => strip_tags( translate('adminify.pwa.images') ),
            "value" => empty($imagesSettings->data) ? '' : $imagesSettings->data,
        ]);

        $this->add('js', 'textarea', [
            "label" => strip_tags( translate('adminify.pwa.js') ),
            "value" => empty($jsSettings->data) ? '' : $jsSettings->data,
        ]);

        $this->add('css', 'textarea', [
            "label" => strip_tags( translate('adminify.pwa.css') ),
            "value" => empty($cssSettings->data) ? '' : $cssSettings->data,
        ]);

        $this->addSubmit();
    }
    
}
