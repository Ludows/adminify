<?php

namespace Ludows\Adminify\Models;

use App\Models\Menu;
use App\Models\Media;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
class MenuItem extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['overwrite_title'];

    protected $fillable = [
        'model',
        'model_id',
        'overwrite_title',
        'parent_id',
        'media_id',
        'class',
        'open_new_tab'
    ];

    public function toFeedItem(): FeedItem {}
    public function getSearchResult() : SearchResult {}

    public function media()
    {
        return $this->belongsTo(Media::class,'media_id', 'id');
    }

    public function menu() {
        return $this->belongsToMany(Menu::class);
    }

    public function related() {
        return $this->hasOne($this->model, 'id', 'model_id');
    }


}
