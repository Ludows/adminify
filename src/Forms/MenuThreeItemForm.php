<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

class MenuThreeItemForm extends BaseForm
{
    public function buildForm()
    {
        $this->add('type', 'hidden', []);
        $this->add('model', 'hidden', []);
        $this->add('model_id', 'hidden', []);
        $this->add('overwrite_title', 'text', []);
        $this->addMediaLibraryPicker('media_id');
        $this->add('open_new_tab', 'checkbox', []);
        $this->add('class', 'text', []);

        // media_id
    }
}
