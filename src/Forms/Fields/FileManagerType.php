<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;

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
            'btn' => [
                'label' => __('admin.form.select_media'),
                'attr' => ['class' => 'btn btn-default'],
            ]
        );
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);

        $options = $this->getOptions();

        if(isset($options['value']) && $options['value'] != "") {
            $m = $this->parent->getModel();

            if($m instanceof \App\Models\Media == false) {
                $options['attr']['data-path'] = $m->media->path ?? '';
                $options['attr']['data-src'] = $m->media->src ?? '';
            }
            if($m instanceof \App\Models\Media == true) {
                $options['attr']['data-path'] = $m->path ?? '';
                $options['attr']['data-src'] = $m->src ?? '';
            }
            // else {
            //     $options['attr']['data-path'] = $m->path ?? '';
            //     $options['attr']['data-src'] = $m->src ?? '';
            // }

        }

        $this->setOptions([
            'sibling' => Str::slug('media_library_'.$uniqid),
            'modal' => isset($options['modal']) ? $options['modal'] : 'adminify::layouts.admin.modales.modaleFileManager',
            'lfm_options' => array_merge($this->setDefaults(), isset($options['lfm_options']) ? $options['lfm_options'] : [])
        ]);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
