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
        $background_colorSetting = $m->getSetting('background_color');
        $orientationSetting = $m->getSetting('orientation');
        

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
            "value" => empty($descriptionSetting) ? $m->getGlobalSetting('slogan')->data : $descriptionSetting->data,
        ]);

        $this->add('theme_color', 'color', [
            "label" => strip_tags( translate('adminify.pwa.theme_color') ),
            "value" => empty($theme_colorSetting) ? '' : $theme_colorSetting->data,
        ]);

        $this->add('background_color', 'color', [
            "label" => strip_tags( translate('adminify.pwa.background_color') ),
            "value" => empty($background_colorSetting) ? '' : $background_colorSetting->data,
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

        $this->addSubmit();
    }
    
}
