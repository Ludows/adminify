<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Adminify\Models\Tag;

class TagCard extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Tag Card';
    }
    public function getPlural() {
        return 'tags';
    }
    public function limit() {
        return 3;
    }
    public function query() {
        $r = $this->getRequest();
        if($r->useMultilang) {
            $query = Tag::lang($r->lang)->take($this->limit)->get()->all();
        }
        else {
            $query = Tag::take($this->limit)->get()->all();
        }

        // dd($query);

        return $query;
    }
    public function handle() {

        $this->roles(['administrator', 'client']);

    }
    public function addToRender() {
        return [
            'createLink' => route('tags.create')
        ];
    }
}
