<?php

namespace Ludows\Adminify\Models;

use App\Models\Post;
use App\Models\Media;
use Ludows\Adminify\Models\ContentTypeModel;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;
class Category extends ContentTypeModel
{
    public $MultilangTranslatableSwitch = ['title', 'slug'];

    protected $fillable = [
        'title',
        'media_id',
        'slug',
        'parent_id',
        'user_id'
    ];

    public function getTableListing() {
      return \Ludows\Adminify\Tables\CategoryTable::class;
   }

    public function getSearchResult() : SearchResult
     {
        $url = route('categories.edit', ['category' => $this->id]);

         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
         );
     }
   public function toFeedItem(): FeedItem {}
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
