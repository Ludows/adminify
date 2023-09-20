<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;

class Statuses extends ClassicModel
{
    protected $table = 'statuses';
    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    const PUBLISHED_ID = 1;
    const DRAFTED_ID = 2;
    const TRASHED_ID = 3;

    public $enable_searchable = false;
    public $enable_revisions = false;

    public $statuses = [
        'published',
        'draft',
        'trash'
    ];

    protected $fillable = [
        'name',
    ];

    public function isScope($query, $key, $operator = '=') {
        return $query->where('name', $operator, $key);
    }
}
