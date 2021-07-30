<?php

namespace Ludows\Adminify\Interfacable\Blocks;

use Ludows\Adminify\Libs\InterfacableBlock;

use App\Models\Post;

class PostCard extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Post Card';
    }
    public function getPlural() {
        return 'posts';
    }
    public function limit() {
        return 3;
    }
    public function query() {
        $r = $this->getRequest();
        if($r->useMultilang) {
            $query = Post::lang($r->lang)->take($this->limit)->get()->all();
        }
        else {
            $query = Post::take($this->limit)->get()->all();
        }

        // dd($query);

        return $query;
    }
    public function handle() {

        $this->roles(['administrator', 'client']);

    }
}
