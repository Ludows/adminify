<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class SaveMissingTraductions extends Form
{
    public function buildForm()
    {
        $datas = $this->getData();

        if(isset($datas['clsForm'])) {

            $formChild = $datas['clsForm'];
            $fields = $formChild->getFields();
            $m = $datas['model'];

            $fillables = $m->getFillable();

            $this->add('from', 'hidden', [
                'value' => $datas['fromLang']
            ]);

            $this->add('current_lang', 'hidden', [
                'value' => $datas['actualLang']
            ]);

            $this->add('type', 'hidden', [
                'value' => $datas['type']
            ]);

            $this->add('id', 'hidden', [
                'value' => $datas['id']
            ]);

            $this->add('current_trad', 'static', [
                'label' => __('admin.current_trad'),
                'tag' => 'div', // Tag to be used for holding static data,
                'attr' => ['class' => 'form-control-static'], // This is the default
                'value' => is_translatable_model($m) ? $m->getTranslation($fillables[0], $datas['fromLang']).__('admin.current_lang') : $m->{$fillables[0]}.__('admin.current_lang') // If nothing is passed, data is pulled from model if any
            ]);

            foreach ($fields as $fieldKey => $value) {
                # code...
                //dd($datas);
                if(!in_array($fieldKey, $datas['config']['excludes'])) {
                    $this->add($fieldKey, $value->getName() == 'submit' ? 'submit' : 'text', $value->getOptions());
                }
            }
        }
    }
}
