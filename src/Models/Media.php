<?php

namespace Ludows\Adminify\Models;

use App\Models\Post;
use Ludows\Adminify\Traits\PathableMedia;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Feed\FeedItem;
use Spatie\Searchable\SearchResult;

class Media extends ClassicModel
{
    use PathableMedia;

    protected $table = 'medias';

    public $MultilangTranslatableSwitch = ['alt', 'description'];

    public $sitemapCallable = 'path';

    protected $fillable = [
        'src', //the path you uploaded the image
        'mime_type',
        'description',
        'alt',
    ];

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    public function getPathAttribute() {
        return $this->getFullPath($this->src) . '/' . $this->src;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
