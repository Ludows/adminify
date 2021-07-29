<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class CreateMail extends Form
{
    public function buildForm()
    {
        $mailables = $this->getMailables();

        //@todo
        $this->add('mailable', 'select2', [
            'empty_value' => '',
            'withCreate' => false,
            'modal' => '', // simple include
            'choices' => $mailables['mailables'],
            'selected' => $mailables['selected'],
            'label' => __('admin.form.mailable'),
            'select2options' => [
                'placeholder' => __('admin.select_mailable'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);

        $this->add('subject', 'text', [
            'label_show' => false,
            'attr' => ['placeholder' => __('admin.form.subject')],
        ]);

        $this->add('html_template', 'summernote', [
            'label_show' => false,
            'attr' => ['placeholder' => __('admin.form.html_template')],
        ]);
        
    }
    public function getMailables() {
        $m = app('App\Models\Mailables');

        $mailables = $m->all();
        $mails = [];
        $selecteds = [];
        $mailables = $m->all();
        
        foreach ($mailables as $mail) {
            # code...
            $mails[$mail->mailable] = $mail::getSubject();
        }

        $r = $this->getRequest();

        if($r->exist('mail')) {
            // on a une selection
            $mailFetched = $r->mail;
            $selecteds = [$mailFetched->mailable];
        }

        return [ 'mailables' => $mails, 'selected' => $selecteds];
    }
}
