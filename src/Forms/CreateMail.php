<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class CreateMail extends Form
{
    public function buildForm()
    {
        $mailables = $this->getMailables();

        //@todo
        $this->add('subject', 'text', [
            'label_show' => false,
            'attr' => ['placeholder' => __('admin.form.subject')],
        ]);

        $this->add('mailable', 'select2', [
            'empty_value' => '',
            'withCreate' => false,
            'modal' => '', // simple include
            'choices' => $mailables['mailables'],
            'selected' => $mailables['selected'],
            'label' => __('admin.form.mailable_template'),
            'select2options' => [
                'placeholder' => __('admin.select_mailable_template'),
                'multiple' => false,
                'width' => '100%'
            ]
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
        $mailables = $mailables->all();

        foreach ($mailables as $mail) {
            # code...
            $mails[$mail->mailable] = $mail->mailable::getSubject();
        }

        $r = $this->getRequest();

        if($r->exists('mail')) {
            // on a une selection
            $mailFetched = $r->mail;
            $selecteds = [$mailFetched->mailable];
        }

        return [ 'mailables' => $mails, 'selected' => $selecteds];
    }
}
