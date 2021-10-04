<?php

namespace Ludows\Adminify\Models;

use App\Adminify\Models\Menu;
use App\Adminify\Models\Media;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

use Ludows\Adminify\Models\ClassicModel;
class MenuItem extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['overwrite_title'];

    public $enable_searchable = false;

    protected $fillable = [
        'model',
        'model_id',
        'overwrite_title',
        'parent_id',
        'media_id',
        'class',
        'open_new_tab'
    ];

    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [
        'model_id' => NULL,
        'type' => NULL,
        'overwrite_title' => NULL,
        'media_id' => 0,
        'parent_id' => 0,
        'class' => NULL,
        'open_new_tab' => 0,
     ];

    public function toFeedItem(): FeedItem {}

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
