<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;

class Statistics extends ClassicModel
{
    protected $table = 'statistics';
    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    public $enable_searchable = false;

    protected $fillable = [
        'url',
        'type',
        'event_name',
        'browser',
        'browser_version',
        'device_type',
        'visited_at'
    ];   
}
