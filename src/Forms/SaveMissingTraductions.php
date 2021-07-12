<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

use Ludows\Adminify\Models\Menu;

class SaveMissingTraductions extends Form
{
    public function buildForm()
    {
        $datas = $this->getData();
        
        if(isset($datas['clsForm'])) {
            
            $formChild = $datas['clsForm'];
            $fields = $formChild->getFields();

            foreach ($fields as $fieldKey => $value) {
                # code...
                if(!in_array($fieldKey, $datas['config']['excludes'])) {
                    $this->add($fieldKey, 'text', []);
                }
            }
        }
    }
}
