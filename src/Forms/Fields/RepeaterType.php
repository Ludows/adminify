<?php
namespace Ludows\Adminify\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\CollectionType;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Fields\FormField;

class RepeaterType extends CollectionType {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'adminify::fields.repeater';
    }

    public function setDefaultsOptions() {
        return array();
    }

    /**
     * Generate prototype for regular form field.
     *
     * @param FormField $field
     * @return void
     */
    protected function generatePrototype(FormField $field)
    {

        $value = $this->makeNewEmptyModel();
        $field->setOption('is_prototype', true);
        $field = $this->setupChild($field, $this->getPrototypeName(), $value);

        // dd($field);

        if ($field instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType) {
            foreach ($field->getChildren() as $child) {
                $child->setOption('is_child_proto', true);
                $child->setOption('force_js', true);
                if ($child instanceof CollectionType) {
                    $child->preparePrototype($child->prototype());
                }
            }
        }


        $this->proto = $field;
    }

    public function getTemplateItem() {
        $options = $this->getOptions();
        $str = '';

        $str .= '<div class="card">';
        $str .= '<div class="card-header" id="heading'. $options["prototype_name"] .'">';
        $str .= ' <h2 class="mb-0">';
        $str .= '<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse'. $options["prototype_name"] .'" aria-expanded="false" aria-controls="collapse'. $options["prototype_name"] .'">';
        $str .=     'Item '. $options["prototype_name"];
        $str .= '</button>';
        $str .= '</h2>';
        $str .= '</div>';
        $str .= '<div id="collapse'. $options["prototype_name"] .'" class="collapse" aria-labelledby="heading'. $options["prototype_name"] .'" data-parent="#accordion-##SIBLING##">';
        $str .= '<div class="card-body">';
        $str .= '##FORM##';
        $str .= '</div>';
        $str .= '</div>';
        $str .= '</div>';
        return $str;
    //     return "<div class=\"card\">
    //     <div class=\"card-header\" id=\"heading'. $options["prototype_name"] .'\">
    //         <h2 class=\"mb-0\">
    //             <button class=\"btn btn-link btn-block text-left\" type=\"button\" data-toggle="collapse" data-target="#collapse'. $options["prototype_name"] .'" aria-expanded="false" aria-controls="collapse'. $options["prototype_name"] .'">
    //                 Item '. $options["prototype_name"] .'
    //             </button>
    //         </h2>
    //     </div>

    //     <div id="collapse'. $options["prototype_name"] .'" class="collapse" aria-labelledby="heading'. $options["prototype_name"] .'" data-parent="#accordion-##SIBLING##">
    //         <div class="card-body">
    //             ##FORM##
    //         </div>
    //     </div>
    // </div>";
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $uniqid = Str::random(9);
        $options = array_merge($this->getOptions() , $options);

        $isAjax = request()->ajax();

        $sibling = '';
        if(isset($options['force_sibling']) && $options['force_sibling'] == true && isset($options['sibling'])) {
            $sibling = $options['sibling'];
        }
        else {
            $sibling = Str::slug('repeater_'.$uniqid);
        }

        if(isset($options['force_js']) && $options['force_js'] == true) {
            $isAjax = true;
        }


        // $getSubmit = $this->getParent()->getField('submit');
        // if(!empty($getSubmit)) {
        //     $options = $getSubmit->getOptions();
        //     if($options['attr'] && !empty($options['attr']['class'])) {
        //         $spl = explode(' ', $options['attr']['class']);
        //         // dd($spl);
        //         $spl[] = 'js-bind-repeater';

        //         $getSubmit->setOption('attr.class', join(' ', $spl));
        //     }
        // }

        $b = [
            'isAjax' => $isAjax,
            'sibling' => $sibling,
            'name' => $this->getName(),
            'currentForm' => $this->getParent(),
            'accordion_item' => $this->getTemplateItem()
        ];

        $options = array_merge($options, $b);

        // $this->setOptions($options);

        // if(!empty($options['prototype']) && $options['prototype'] == true) {
        //     view()->share('dis')
        // }

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
