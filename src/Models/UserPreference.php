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

    public $enable_searchable = false;

    public $MultilangTranslatableSwitch = [];

    protected $fillable = [
        'user_id',
        'type',
        'data'
    ];

    public function scopeType($query, $key, $operator = '=') {
        return $query->where('type', $operator, $key);
    }
    public function scopeUserId($query, $key, $operator = '=') {
        return $query->where('user_id', $operator, $key);
    }

    public function scopeData($query, $key, $operator = '=') {
        return $query->where('data', $operator, $key);
    }

    public function user()
    {
        return $this->HasOne(User::class, 'id', 'user_id');
    }
}
