<?php

namespace Ludows\Adminify\Models;

use App\Models\Post;
use Ludows\Adminify\Traits\PathableMedia;

use Ludows\Adminify\Models\ClassicModel;

class Media extends ClassicModel
{
    protected $table = 'medias';
    
    use PathableMedia;

    public $sitemapCallable = 'path';

    protected $fillable = [
        'src', //the path you uploaded the image
        'mime_type',
        'description',
        'alt',
    ];

    public function getPathAttribute() {
        return $this->getFullPath($this->src) . '/' . $this->src;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
