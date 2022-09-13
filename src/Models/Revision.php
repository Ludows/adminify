<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
use Spatie\Menu\Laravel\Link;


class Revision extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['data'];

    protected $fillable = [
        'data',
        'model_class',
        'model_id',
    ];

    public $enable_searchable = false;
    protected $useSlugGeneration = false;
    public $enable_revisions = false;

    public function getSavableForm() {
        return null;
    }

    public function toFeedItem(): FeedItem {}
}