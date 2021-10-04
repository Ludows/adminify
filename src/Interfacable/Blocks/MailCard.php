<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Adminify\Models\Mailables;

class MailCard extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Mails Card';
    }
    public function getPlural() {
        return 'mails';
    }
    public function showColumn() {
        return 'subject';
    }
    public function limit() {
        return 3;
    }
    public function query() {
        $r = $this->getRequest();
        if($r->useMultilang) {
            $query = Mailables::lang($r->lang)->take($this->limit)->get()->all();
        }
        else {
            $query = Mailables::take($this->limit)->get()->all();
        }

        // dd($query);

        return $query;
    }
    public function handle() {

        $this->roles(['administrator']);

    }
    public function addToRender() {
        return [
            'createLink' => route('mails.create')
        ];
    }
}
