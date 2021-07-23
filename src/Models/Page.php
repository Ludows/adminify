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

    public function getTableListing() {
        return \Ludows\Adminify\Tables\PageTable::class;
    }

    public $excludes_savables_fields = [
        'media_id',
        'parent_id'
    ];
    
    public $unmodified_savables_fields = [
        'content',
        'categories_id',
        'submit'
    ];

    public function getSavableForm() {
        return \App\Forms\CreatePage::class;
    }

    protected $fillable = [
        'title',
        'slug',
        'content',
        'media_id',
        'parent_id',
        'user_id',
        'status_id'
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
