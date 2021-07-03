<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

use App\Models\Page;
use App\Models\Settings;

class CreateSettings extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $home = $this->getStatePage('homepage');
        $blog = $this->getStatePage('blogpage');

        $this->add('site_name', Field::TEXT, [
            'value' => $this->getSetting('site_name')
        ])
        ->add('site_slogan', Field::TEXT, [
            'value' => $this->getSetting('site_slogan')
        ])
        ->add('logo_src', 'lfm', [
            'label_show' => false,
            'value' => $this->getSetting('logo_src')
        ])
        ->add('homepage', 'select2', [
            'empty_value' => _('admin.select_homepage'),
            'choices' => $home['datas'],
            'selected' => $home['selected'],
            'select2options' => [
                'multiple' => false,
                'width' => '100%'
            ]
        ])
        ->add('blogpage', 'select2', [
            'empty_value' => _('admin.select_blogpage'),
            'choices' => $blog['datas'],
            'selected' => $blog['selected'],
            'select2options' => [
                'multiple' => false,
                'width' => '100%'
            ]
        ]);

        $this->add('submit', 'submit', ['label' => _('admin.save'), 'attr' => ['class' => 'btn btn-default']]);
    }
    public function getStatePage($settingName = '') {

        $setting = $this->getSetting($settingName, 'model');
        $selected = null;
        if($setting != null) {
            $selected = $setting->page;
        }


        return [
            'datas' => Page::all()->pluck('title', 'id')->all(),
            'selected' => isset($selected) ? $selected->id : ''
        ];
    }
    public function getSetting($name = '', $typed = 'val') {
        $request = request();
        $query = new Settings();
        $query = $query->where('type', $name);

        $query = $query->first();

        return $typed == 'val' && $query != null ? $query->data : $query;
    }
}
