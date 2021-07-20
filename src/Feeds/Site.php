<?php

namespace Ludows\Adminify\Feeds;

use App\Models\Page;
use App\Models\Post;

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