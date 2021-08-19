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
        $comments = $this->getSetting('no_comments');
        $seo = $this->getSetting('no_seo');

        $this->add('site_name', Field::TEXT, [
            'label' => __('admin.form.site_name'),
            'value' => $this->getSetting('site_name')
        ])
        ->add('site_slogan', Field::TEXT, [
            'label' => __('admin.form.site_slogan'),
            'value' => $this->getSetting('site_slogan')
        ])
        ->add('logo_id', 'lfm', [
            'label_show' => false,
            'value' => $this->getMedia( $this->getSetting('logo_id') ) ?? null
        ])
        ->add('homepage', 'select2', [
            'empty_value' => __('admin.form.select_entity', ['entity' => 'page']),
            'choices' => $home['datas'],
            'selected' => $home['selected'],
            'label' => __('admin.form.homepage'),
            'select2options' => [
                'multiple' => false,
                'width' => '100%'
            ]
        ])
        ->add('blogpage', 'select2', [
            'empty_value' => __('admin.form.select_entity', ['entity' => 'page']),
            'choices' => $blog['datas'],
            'selected' => $blog['selected'],
            'label' => __('admin.form.blogpage'),
            'select2options' => [
                'multiple' => false,
                'width' => '100%'
            ]
        ])
        ->add('no_comments', 'checkbox', [
            'label_show' => true,
            'label' => __('admin.form.no_comments_globally'),
            'value' => $comments != null ? 0 : 1,
            'checked' => $comments != null ? true : false
        ])
        ->add('no_seo', 'checkbox', [
            'label_show' => true,
            'label' => __('admin.form.no_seo'),
            'value' => $seo != null ? 0 : 1,
            'checked' => $seo != null ? true : false
        ]);

        $this->add('submit', 'submit', ['label' => _('admin.form.save'), 'attr' => ['class' => 'btn btn-default']]);
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
    public function getMedia($id) {
        $mediaModel = app('App\Models\Media');

        return $mediaModel->find($id);
    }
}
