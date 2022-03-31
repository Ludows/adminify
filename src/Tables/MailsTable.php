<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
class MailsTable extends TableManager {
    public function getDropdownManagerClass() {
        return App\Adminify\Dropdowns\Mail::class;
    }
    public function getModelClass() {
        return App\Adminify\Models\Mailables::class;
    }
    public function handle() {

        parent::handle();

        // add js 
        $this->js( asset('adminify/back').'/js/sendMail.js' );
    }
}
