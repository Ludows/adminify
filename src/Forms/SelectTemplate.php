<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

use App\Adminify\Models\Templates;
class SelectTemplate extends BaseForm
{
    public function buildForm()
    {
        $t = $this->getTemplates();
        // Add fields here...
        $this->add('items', 'select2', [
            'label' => __('admin.form.items'),
            'choices' => $t['templates']
        ]);
        $this->add('submit', 'submit', ['label' => __('admin.form.add') , 'attr' => ['class' => 'btn btn-default']]);

    }
    public function getTemplates() {
        $templates = Templates::get()->pluck('title' ,'id');

        return [ 'templates' => $templates->all(), 'selected' => ''];
    }
}
