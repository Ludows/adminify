<?php

namespace Ludows\Adminify\Models;

use Spatie\Searchable\SearchResult;

use Ludows\Adminify\Models\ContentTypeModel;
class Page extends ContentTypeModel
{
    public $MultilangTranslatableSwitch = ['title', 'slug', 'content'];

    public function getSearchResult() : SearchResult
    {
       $url = route('pages.edit', ['page' => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->title,
           $url
        );
    }

    protected $fillable = [
        'title',
        'slug',
        'content',
        'media_id',
        'parent_id',
        'user_id'
    ];
    public function media()
    {
        return $this->belongsTo(Media::class,'media_id', 'id');
    }
    public function categories()
    {
       return $this->belongsToMany(Category::class);
    }
}
