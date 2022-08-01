<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

class SaveMissingTraductions extends BaseForm
{
    public function buildForm()
    {
        $datas = $this->getData();

        if(isset($datas['clsForm'])) {

            $formChild = $datas['clsForm'];
            $fields = $formChild->getFields();
            $m = $datas['model'];
            $excludes = $m->excludes_savables_fields;
            $modifiables_fields = $m->unmodified_savables_fields;

            $fillables = $m->getFillable();

            $this->add('from', 'hidden', [
                'value' => $datas['fromLang']
            ]);

            $this->add('current_lang', 'hidden', [
                'value' => $datas['actualLang']
            ]);

            $this->add('model', 'hidden', [
                'value' => $datas['type']
            ]);

            $this->add('id', 'hidden', [
                'value' => $datas['id']
            ]);

            $this->add('current_trad', 'static', [
                'label' => __('admin.form.current_trad'),
                'tag' => 'div', // Tag to be used for holding static data,
                'attr' => ['class' => 'form-control-static'], // This is the default
                'value' => is_translatable_model($m) ? $m->getTranslation($fillables[0], $datas['fromLang']).__('admin.form.current_lang') : $m->{$fillables[0]}.__('admin.form.current_lang') // If nothing is passed, data is pulled from model if any
            ]);

            foreach ($fields as $fieldKey => $value) {
                # code...
                //dd($datas);
                if(!in_array($fieldKey, $excludes)) {
                    $type = null;
                    if(!in_array($fieldKey, $modifiables_fields)) {
                        $type = 'text';
                    }
                    else {
                        $type = $value->getType();
                    }
                    $this->add($fieldKey, $type, $value->getOptions());
                }
            }
        }
    }
}
