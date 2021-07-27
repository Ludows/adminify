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

    public $excludes_savables_fields = [];
    public $unmodified_savables_fields = [
        'submit'
    ];
    public function getSavableForm() {
        return \App\Forms\CreateTag::class;
    }

    public function getTableListing() {
        return \Ludows\Adminify\Tables\TagTable::class;
    }
    
    protected $fillable = [
        'title',
        'slug',
    ];
}
