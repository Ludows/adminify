<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;
use Closure;

class FileManagerType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.lfm';
    }

    public function setDefaults() {
        return array(
            'override_media_method' => null,
            'disable_selection_preview' => false,
            'multiple' => false,
            'btn' => [
                'label' => __('admin.form.select_media'),
                'attr' => ['class' => 'btn btn-default'],
            ]
        );
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);

        $options = array_merge($this->getOptions(), $options);
        $isAjax = request()->ajax();

        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }

        if(isset($options['value']) && $options['value'] != "") {
            $m = $this->parent->getModel();

            if(isset($options['override_media_method']) && $options['override_media_method'] instanceof Closure && !is_array($m)) {
                $options = $options['override_media_method']($m, $options);
            }

            if($m instanceof \App\Adminify\Models\Media == false && !is_array($m) && !isset($options['override_media_method'])) {
                $options['attr']['data-path'] = $m->media->path ?? '';
                $options['attr']['data-src'] = $m->media->src ?? '';
            }
            if($m instanceof \App\Adminify\Models\Media == true && !isset($options['override_media_method'])) {
                $options['attr']['data-path'] = $m->path ?? '';
                $options['attr']['data-src'] = $m->src ?? '';
            }
            // else {
            //     $options['attr']['data-path'] = $m->path ?? '';
            //     $options['attr']['data-src'] = $m->src ?? '';
            // }

        }

        $sibling = '';
        if(isset($options['force_sibling']) && $options['force_sibling'] == true && isset($options['sibling'])) {
            $sibling = $options['sibling'];
        }
        else {
            $sibling = Str::slug('media_library_'.$uniqid);
        }

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'name' => $this->getName(),
            'modal' => isset($options['modal']) ? $options['modal'] : 'adminify::layouts.admin.modales.modaleFileManager',
            'lfm_options' => array_merge($this->setDefaults(), isset($options['lfm_options']) ? $options['lfm_options'] : [])
        ];

        $options = array_merge($options, $b);

        $this->setOptions($options);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
