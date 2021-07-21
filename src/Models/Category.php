<?php

namespace Ludows\Adminify\Models;

use App\Models\Post;
use App\Models\Media;
use Ludows\Adminify\Models\ContentTypeModel;
class Category extends ContentTypeModel
{
    public $MultilangTranslatableSwitch = ['title', 'slug'];

    protected $fillable = [
        'title',
        'media_id',
        'slug',
        'parent_id',
    ];

    public function getSearchResult(): SearchResult
     {
        $url = route('categories.edit', ['category' => $this->id]);

         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
         );
     }
   public function media() {
      return $this->belongsTo(Media::class,'media_id', 'id');
   }
    public function categories()
    {
       return $this->hasMany(Category::class);
    }

    public function children()
    {
       return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function childrens()
    {
       return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function posts() {
        return $this->belongsToMany(Post::class);
    }
}
