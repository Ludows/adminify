<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;

class Seo extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['data'];

    protected $table = 'seo';

    protected $fillable = [
        'model_name',
        'model_id',
        'type',
        'data',
    ];

    public $enable_searchable = false;

    public function toFeedItem(): FeedItem {}

    public function scopeType($query, $type) {
        return $query->where('type', $type);
    }
    public function scopeModelId($query, $id) {
        return $query->where('model_id', $id);
    }
    public function scopeModelName($query, $class) {
        return $query->where('model_name', $class);
    }
}
