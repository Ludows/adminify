<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicModel;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

class UserPreference extends ClassicModel
{
    protected $table = 'user_preferences';

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    public function getTableListing() {
        return null;
    }


    public $MultilangTranslatableSwitch = [];

    protected $fillable = [
        'user_id',
        'type',
        'data'
    ];

    public function user()
    {
        return $this->HasOne(User::class, 'id', 'user_id');
    }
}
