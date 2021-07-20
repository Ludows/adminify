<?php

namespace Ludows\Adminify\Feeds;

use App\Models\Page;
use App\Models\Post;

class Site {
    public function all() {
        $a = Page::all()->all();
        $b = Post::all()->all();
        return array_merge($a, $b);
    }
    public function pages() {
        return Page::all();
    }
    public function posts() {
        return Post::all();
    }
}