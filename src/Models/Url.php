<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;
use Ludows\Adminify\Models\ClassicModel;
class Url extends ClassicModel
{
    protected $table = 'urls';
    // use HasFactory;
    // use Helpers;

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    protected $fillable = [
        'from_model',
        'from_model_id',
        'model_name',
        'model_id', 
    ];
}
