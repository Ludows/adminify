<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

use App\Adminify\Models\Page;
use App\Adminify\Models\Settings;

use File;

class CreateSettings extends BaseForm
{
    public function buildForm()
    {
        // Add fields here...
        $home = $this->getStatePage('homepage');
        $blog = $this->getStatePage('blogpage');
        $search = $this->getStatePage('searchpage');
        $comments = $this->getSetting('no_comments');
        $searchpage_models_tags = $this->getSetting('searchpage_models_tags');
        $theme = $this->getSetting('theme');
        $seo = $this->getSetting('no_seo');
        $enabled_features = $this->getFeaturesSite();
        $titleBar = $this->getSetting('exclude_titlebar');
        $breadcrumb = $this->getSetting('exclude_breadcrumb');
        $enable_comments_on = $this->getSetting('enables_comments');


        if(is_null($comments)) {
            $comments = 0;
        }

        if(is_null($seo)) {
            $seo = 0;
        }

        $this->add('site_name', Field::TEXT, [
            'label' => __('admin.form.site_name'),
            'value' => $this->getSetting('site_name')
        ])
        ->add('site_slogan', Field::TEXT, [
            'label' => __('admin.form.site_slogan'),
            'value' => $this->getSetting('site_slogan')
        ]);
        if(isset($enabled_features['media']) && $enabled_features['media']) {

            $this->add('logo_id', 'media_element', [
                'label_show' => false,
                'value' => $this->getSetting('logo_id')
            ]);
        }
        $this->add('homepage', 'select2', [
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
        ->add('searchpage', 'select2', [
            'empty_value' => __('admin.form.select_entity', ['entity' => 'search']),
            'choices' => $search['datas'],
            'selected' => $search['selected'],
            'label' => __('admin.form.searchpage'),
            'select2options' => [
                'multiple' => false,
                'width' => '100%'
            ]
        ])
        ->add('exclude_titlebar', 'select2', [
            'attr' => [
                'multiple' => true
            ],
            'empty_value' => __('admin.form.select_entity', ['entity' => 'titlebar']),
            'label' => 'Exclure la barre de Titre',
            'choices' => Page::all()->pluck('title', 'slug')->all(),
            'selected' => explode(',',$titleBar) ?? '',
            'select2options' => [
                'multiple' => true,
            ]
        ])
        ->add('exclude_breadcrumb', 'select2', [
            'attr' => [
                'multiple' => true
            ],
            'empty_value' => __('admin.form.select_entity', ['entity' => 'titlebar']),
            'label' => 'Exclure la Breadcrumb',
            'choices' => Page::all()->pluck('title', 'slug')->all(),
            'selected' => explode(',',$breadcrumb) ?? '',
            'select2options' => [
                'multiple' => true,
            ]
        ])
        ->add('searchpage_models_tags', 'select2', [
            'empty_value' => __('admin.form.select_entity', ['entity' => 'searchpage_models_tags']),
            'choices' => array_keys( get_site_key('searchable') ),
            'selected' => !is_null($searchpage_models_tags) ? $searchpage_models_tags : '',
            'label' => __('admin.form.searchpage_models_tags'),
            'select2options' => [
                'multiple' => false,
                'width' => '100%'
            ]
        ])
        ->add('theme', 'select2', [
            'empty_value' => __('admin.form.select_theme', ['entity' => 'theme']),
            'choices' => $this->formatThemesChoices(),
            'selected' => $theme,
            'label' => __('admin.form.select_theme'),
            'select2options' => [
                'multiple' => false,
                'width' => '100%'
            ]
        ]);

        if(isset($enabled_features['comment']) && $enabled_features['comment']) {

            $this->add('enables_comments', 'select2', [
                'attr' => [
                    'multiple' => true
                ],
                'empty_value' => __('admin.form.select_entity', ['entity' => 'entité']),
                'label' => 'Enable comments on',
                'choices' => get_content_types(),
                'selected' => explode(',',$enable_comments_on) ?? '',
                'select2options' => [
                    'multiple' => true,
                ]
            ]);
        }

        // ->add('no_comments', 'hidden', [
        //     'value' => 0
        // ])
        $this->add('no_comments', 'checkbox', [
            'label_show' => true,
            'label' => __('admin.form.no_comments_globally'),
            'value' => $comments != null && $comments == 0 ? 1 : 0,
            'checked' => $comments != null && $comments != 0 ? true : false,
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input'],
            'label_attr' => ['class' => 'custom-control-label text-muted'],
        ])
        // ->add('no_seo', 'hidden', [
        //     'value' => 0
        // ])
        ->add('no_seo', 'checkbox', [
            'label_show' => true,
            'label' => __('admin.form.no_seo'),
            'value' => $seo != null && $seo == 0 ?  1 : 0,
            'checked' => $seo != null && $seo != 0 ? true : false,
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input'],
            'label_attr' => ['class' => 'custom-control-label text-muted'],
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
        $mediaModel = app('App\Adminify\Models\Media');

        return $mediaModel->find($id);
    }
    public function formatThemesChoices() {
       $results = [];
       if(file_exists(theme_path())) {
            $dirs = File::directories(theme_path());
            foreach ($dirs as $dir) {
                # code...
                $dirName = basename($dir);
                $results[$dirName] = $dirName;
            }
       }
       return $results;
    }
}
