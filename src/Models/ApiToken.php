<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicModel;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

class ApiToken extends ClassicModel
{
    protected $table = 'api_tokens';

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    public function getTableListing() {
        return null;
    }

    protected $fillable = [
        'name',
        'user_id',
        'token',
        'abilities',
        'expiration_date',
        'ip_adress'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
