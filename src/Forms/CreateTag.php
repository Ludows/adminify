<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;


class CreateTag extends Form
{
    public function buildForm()
    {
        // $hydrator = $this->hydrateSelect();
        $m = $this->getModel();

            $this->add('title', Field::TEXT, [
                'label' => __('admin.form.title'),
            ]);
            
            $this->add('submit', 'submit', ['label' => __('admin.create'), 'attr' => ['class' => 'btn btn-default']]);
    }

}
