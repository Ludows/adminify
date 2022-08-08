<?php

namespace Ludows\Adminify\Libs;

use Error;
use Kris\LaravelFormBuilder\Form;
use Mail;

class FrontifyForms extends Form {
    
    protected $didSendMail = true;
    protected $recipient = '';
    protected $cc = [];
    protected $bcc = '';

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
        $this->booted();
    }
    public function setDefaultsSetting() {
        $this->show_form_when_validated = true;
        $this->formOptions = ['method' => 'POST', 'url' => route('forms.validate')];
    }

    // function is triggered before send mail :)
    public function prepareMail() {

        if(empty($this->recipient)) {
            throw new Error('recipient property must be declared in '. get_class($this), 500);
        }

        $mailer = Mail::to($this->recipient);

        if(!empty($this->cc)) {
            $mailer = $mailer->cc($this->cc);
        }

        if(!empty($this->bcc)) {
            $mailer = $mailer->bcc($this->bcc);
        }

        if(method_exists($this, 'addAttachment')) {
            $pathsFile = $this->addAttachment();

            if(empty($pathsFile)) {
                throw new Error('attachment files are empty', 500);
            }
            if(is_array($pathsFile)) {
                foreach($pathsFile  as $file) {
                    $mailer = $mailer->attach($file);
                }
            }
            else {
                $mailer = $mailer->attach($pathsFile);
            }
        }

        return $mailer;
    }

    public function getMailTemplate() {
        return 'App\Adminify\Mails\FormEntriesListingMail';
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

    public function sendMail() {
        $mail = $this->prepareMail();
        $tplMail = $this->getMailTemplate();

        if(empty($mail)) {
            throw new Error('Prepare function in '. get_class($this) . ' must return a Mail Instance', 500);
        }

        if(empty($tplMail)) {
            throw new Error('getMailTemplate function in '. get_class($this) . ' must return a Class', 500);
        }

        $tplMail = new $tplMail();

        if(method_exists($this, 'beforeSending')) {
            $this->beforeSending($mail, $tplMail);
        }

        $mail->send( new $tplMail() );

        if(method_exists($this, 'afterSending')) {
            $this->afterSending($mail, $tplMail);
        }
    }
    // protected function getTemplate() {
    //     return 'adminify::layouts.commons.forms.default';
    // }
    public function getView() {
        return 'adminify::layouts.commons.forms.default';
    }
}
