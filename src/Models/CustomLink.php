<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
class CustomLink extends ClassicModel
{
    protected $table = 'custom_links';

    public $MultilangTranslatableSwitch = ['title', 'slug'];

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    protected $fillable = [
        'title',
        'slug',
    ];
}
