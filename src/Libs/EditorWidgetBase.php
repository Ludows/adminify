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
   }
   public function handle() {
       
        

   }
   public function renderBlock() {}
   public function renderSettings() {}
}
