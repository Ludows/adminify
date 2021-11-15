<?php

namespace Ludows\Adminify\Libs;

class EditorWidgetBase
{
   public function __construct() {
        $this->view = view();
        $this->request = request();
        $this->form = [];
        $this->formbuilder = app('Kris\LaravelFormBuilder\FormBuilder');
        $this->uuid = 'widget_'.uuid(20);
        $this->showInGroups = [];
        $this->namedBlock = $this->getNamedBlock();
        $this->icon = $this->getIcon();
   }
   public function handle() {
       
        

   }
   public function renderBlock() {}
   public function renderSettings() {}
   public function getIcon() {
      return 'fa fa-clock'; // it's the sample
   }
   public function getNamedBlock() {
      return 'Sample Block Name';
   }

}
