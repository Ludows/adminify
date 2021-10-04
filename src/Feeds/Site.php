<?php

namespace Ludows\Adminify\Feeds;

use App\Adminify\Models\Page;
use App\Adminify\Models\Post;

class Site {
    public function all() {
        $a = Page::all();
        $b = Post::all();
        return $a->merge($b);
    }
    public function pages() {
        return Page::all();
    }
    public function posts() {
        return Post::all();
    }
}