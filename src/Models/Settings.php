<?php

namespace Ludows\Adminify\Models;

use App\Models\Page;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;

class Settings extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['data'];

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    protected $fillable = [
        'type',
        'data',
    ];
    public function page() {
        return $this->belongsTo(Page::class, 'data', 'id');
    }
}
