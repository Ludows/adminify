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

    public function getTableListing() {
        return \Ludows\Adminify\Tables\TagTable::class;
    }
    
    protected $fillable = [
        'title',
        'slug',
    ];
}
