<?php
namespace Ludows\Adminify\Forms\Fields;

use Closure;
use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;

class MediaElementType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.media_element';
    }

    public function setDefaultsOptions() {
        return array(
            'media' => null,
            'multiple' => false,
            'btn' => [
                'label' => __('admin.form.select_media'),
                'attr' => ['class' => 'btn btn-default js-modal-picker'],
            ]
        );
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);
        $options = array_merge($this->getOptions() , $options);
        $mediaModel = app('App\Adminify\Models\Media');
        $value = $this->getValue();
        $values = null;
        $medias = null;
        $hasValue = !empty($value);
        $hasBootedMedia = false;

        $isAjax = request()->ajax();

        $sibling = '';
        if(isset($options['force_sibling']) && $options['force_sibling'] == true && isset($options['sibling'])) {
            $sibling = $options['sibling'];
        }
        else {
            $sibling = Str::slug('media_element_'.$uniqid);
        }


        if(!isset($options['media_element_options'])) {
            $options['media_element_options'] = array();
        }

        if($hasValue) {
            if($value instanceof \Illuminate\Database\Eloquent\Collection) {
                $value = join(',',$value->pluck('id')->toArray() );
                $options['value'] = $value;
            }
            $values = explode(',', $value);
            $medias = $mediaModel->findMany($values);
            $hasBootedMedia = true;
        }


        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'hasBootedMedia' => $hasBootedMedia,
            'medias' => $medias,
            'media_element_options' => array_merge($this->setDefaultsOptions(), isset($options['media_element_options']) ? $options['media_element_options'] : [])
        ];

        $b['media_element_options']['btn']['attr']['data-selector'] = $sibling;

        if($b['hasBootedMedia']) {
            $b['media_element_options']['btn']['attr']['class'] = $b['media_element_options']['btn']['attr']['class'].' d-none';
        }


        $options = array_merge($options, $b);

        $this->setOptions($options);

        // dd($options);
        // dd($this);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
