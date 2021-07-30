<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Models\Media;

class MediaCard extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Media Card';
    }
    public function getPlural() {
        return 'medias';
    }
    public function showColumn() {
        return 'src';
    }
    public function limit() {
        return 3;
    }
    public function query() {
        $r = $this->getRequest();
        if($r->useMultilang) {
            $query = Media::lang($r->lang)->take($this->limit)->get()->all();
        }
        else {
            $query = Media::take($this->limit)->get()->all();
        }

        // dd($query);

        return $query;
    }
    public function handle() {

        $this->roles(['administrator', 'client']);

    }
    public function addToRender() {
        return [
            'createLink' => route('medias.create')
        ];
    }
}
