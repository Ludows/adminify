<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

use File;
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

        $this->add('html_template', 'jodit', [
            'label_show' => false,
            'attr' => ['placeholder' => __('admin.form.html_template')],
        ]);

        $this->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);

    }
    public function getMailables() {
        $mails = [];
        $selecteds = [];
        $r = $this->getRequest();

        $mailFetched = $r->mail;

        $Mails = adminify_get_classes_by_folders(['app:mails', 'app:adminify:mails']);

        foreach($Mails as $MailKey => $Mail){


            // dd($namedClass);
            $m = app($Mail);

            // dd($reflect->name);

            $mails[$MailKey] = $Mail::getSubject();

        }



        if($mailFetched != null) {
            // on a une selection
            $selecteds = [$mailFetched->mailable];
        }

        return [ 'mailables' => $mails, 'selected' => $selecteds];
    }
}
