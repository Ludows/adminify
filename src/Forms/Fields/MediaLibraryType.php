<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MediaLibraryType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.media-library';
    }

    public function setDefaults() {
        return array(
            'btn' => [
                'label' => 'Sélectionner votre Média',
                'attr' => ['class' => 'btn btn-default'],
            ],
            'multiple' => 'false'
        );
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);

        $options = $this->getOptions();

        $this->setOptions([
            'sibling' => Str::slug('media_library_'.$uniqid),
            'modal' => isset($options['modal']) ? $options['modal'] : 'layouts.admin.modales.modaleMediaLibrary',
            'media_library_options' => array_merge($this->setDefaults(), isset($options['media_library_options']) ? $options['media_library_options'] : [])
        ]);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
