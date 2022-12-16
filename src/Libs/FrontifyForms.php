<?php

namespace Ludows\Adminify\Libs;

use Error;
use Kris\LaravelFormBuilder\Form;
use Mail;

class FrontifyForms extends Form {
    
    protected $didSendMail = true;
    protected $confirmationType = 'redirect'; //can be redirect / entity / ajax
    protected $confirmationEntity = null; // put your entity class here

    public function buildForm() {}
    public function booting() {
        $this->setDefaultsSetting();
    }
    public function booted() {}
    public function __construct() {
        $this->booting();
        if (is_callable('parent::__construct')) {
            parent::__construct();
        }
        $this->data = [];
        $this->booted();
    }
    public function setDefaultsSetting() {
        $this->show_form_when_validated = true;
        $this->redirects_parameters = ['formSubmitted' => true];
        $this->formOptions = ['method' => 'POST', 'url' => route('forms.validate')];
    }

    public function getRedirectParameters() {
        return $this->redirects_parameters;
    }

    public function setRedirectParameters($value = []) {
        if(!is_array($value)) {
            throw new Error('setRedirectParameters must have an array');
        }
        $this->redirects_parameters = array_merge($this->redirects_parameters, $value);
        return $this;
    }

    public function getUrlfromEntity() {}

    public function getMailTemplate() {
        return 'App\Adminify\Mails\FormEntriesListingMail';
    }

    public function getConfirmationType() {
        return $this->confirmationType;
    }

    public function getConfirmationContent() {
        return '@todo';
    }

    public function setConfirmationType($value) {
        $this->confirmationType = $value;
        return $this;
    }

    public function confirm() {

        if(!empty($this->confirmationType) && $this->confirmationType == 'entity') {
            $url = $this->getUrlfromEntity();
        }

        if(!empty($this->confirmationType) && $this->confirmationType == 'redirect') {
            $url = $this->confirmationType;
        }

        if(empty($confirmation)) {
            // fallback to previous url
            $url = url()->previous();
        }

        return redirect()->to($url)->with($this->getRedirectParameters());
    }

    public function toJson() {
        $a = [];

        $fields = $this->getFields();
        $a['formOptions'] = $this->getFormOptions();
        $a['fields'] = [];

        $key_fields = array_keys($fields);

        foreach ($key_fields as $key_field) {
            # code...
            $current_field = $fields[$key_field];
            $a['fields'][$key_field]['name'] = $current_field->getName();
            $a['fields'][$key_field]['type'] = $current_field->getType();

            $current_field_options = $current_field->getOptions();
            $current_field_options_keys = array_keys($current_field_options);

            foreach ($current_field_options_keys as $current_field_options_key) {
                # code...
                $a['fields'][$key_field][$current_field_options_key] = $current_field_options[$current_field_options_key];
            }
        }

        return json_encode($a, true);
    }

    public function buildMail($message) {

    }

    public function data(array $array = []) {
        $data = array_merge($this->data, $array);
        return $this;
    }

    public function sendMail() {
        $mailer = mailer();
        $tplMail = $this->getMailTemplate();


        if(empty($tplMail)) {
            throw new Error('getMailTemplate function in '. get_class($this) . ' must return a Class', 500);
        }

        if(method_exists($this, 'beforeSending')) {
            $this->beforeSending();
        }

        $mailer->send( $tplMail,  $this->data , $this->buildMail);

        if(method_exists($this, 'afterSending')) {
            $this->afterSending();
        }
    }
    // protected function getTemplate() {
    //     return 'adminify::layouts.commons.forms.default';
    // }
    public function getView() {
        return 'adminify::layouts.commons.forms.default';
    }
}
