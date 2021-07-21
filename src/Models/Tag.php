<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;
use Ludows\Adminify\Models\ClassicModel;

class Tag extends ClassicModel
{
    protected $table = 'tags';

    public $MultilangTranslatableSwitch = ['title','slug'];

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}
    
    protected $fillable = [
        'title',
        'slug',
    ];
}
