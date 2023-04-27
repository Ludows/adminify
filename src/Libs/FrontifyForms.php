<?php

namespace Ludows\Adminify\Libs;

use Error;
use Ludows\Adminify\Libs\BaseForm as Form;
use Mail;

class FrontifyForms extends Form {
    
    protected $didSendMail = true;
    protected $confirmationType = 'redirect'; //can be redirect / custom
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
        $this->mailer = mailer();
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

    public function getCustomRedirect() {}

    public function getMailTemplate() {
        return null;
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

    public function afterValid($entries) {}

    public function confirm() {
        $url = '';
        $r = request();

        if(!empty($this->confirmationType) && $this->confirmationType == 'custom') {
            $url = $this->getCustomRedirect();
        }

        if(!empty($this->confirmationType) && $this->confirmationType == 'redirect') {
            $url =  url()->previous();
        }

        if(empty($this->confirmationType)) {
            // fallback to previous url
            $url = url()->previous();
        }

        if($r->ajax()) {
            return response()->json(['status' => 'ok', 'confirmation' => $this->getConfirmationContent(), 'url' => $url]);
        }
        else {
            return redirect()->to($url)->with($this->getRedirectParameters());
        }
    }

    public function buildMail($message) {

    }

    public function data(array $array = []) {
        $this->data = array_merge($this->data, $array);
        return $this;
    }

    public function handleLogo() {
        $logo_id = setting('logo_id');
        if(!empty($logo_id)) {
            $media = media( (int) $logo_id );
            if(!empty($media)) {
                $config_mailer = $this->mailer->getData();


                $merge = [
                    'path' => $media->getFullPath(),
                ];

                $logo = array_merge($config_mailer['logo'],  $merge);


                $this->data($logo);
            }
        }
    }

    public function sendMail() {
        $tplMail = $this->getMailTemplate();

        $self = $this;

        if(empty($tplMail)) {
            throw new Error('getMailTemplate function in '. get_class($this) . ' must return a Class', 500);
        }

        $this->handleLogo();

        if(method_exists($this, 'beforeSending')) {
            $this->beforeSending();
        }

        $mailer = $this->mailer;

        $mailer->send( $tplMail,  $this->data , function($message) use ($self, $mailer) {
            call_user_func_array(array($self, 'buildMail'), [$message]);
        });

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
