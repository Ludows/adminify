<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicModel;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

class Comment extends ClassicModel
{
    protected $table = 'api_tokens';

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    public function getTableListing() {
        return null;
    }

    protected $fillable = [
        'comment',
        'parent_id',
        'user_id',
        'post_id',
        'is_moderated',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
