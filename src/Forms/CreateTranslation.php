<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

class CreateTranslation extends BaseForm
{
    public function buildForm()
    {
        // Add fields here...
        
        $this
            ->add('key', Field::TEXT, [
                'label' => __('admin.form.key'),
            ]);
        
        $this->addJodit('text', [
            'label' => __('admin.form.text'),
        ]);
        
        $this->addSubmit();
    }
}
