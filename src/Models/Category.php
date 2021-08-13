<?php

namespace Ludows\Adminify\Models;

use App\Models\Post;
use App\Models\Media;
use Ludows\Adminify\Models\ContentTypeModel;

use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;
use Spatie\Menu\Laravel\Link;
class Category extends ContentTypeModel
{
    public $allowSitemap = false;
    public $MultilangTranslatableSwitch = ['title', 'slug'];

    protected $fillable = [
        'title',
        'media_id',
        'slug',
        'parent_id',
        'user_id'
    ];

    public $excludes_savables_fields = [
      'media_id',
      'parent_id'
    ];
    public $unmodified_savables_fields = [
      'submit'
   ];
    public function getSavableForm() {
       return \App\Forms\UpdateCategory::class;
    }

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

    public function getLinks($menuBuilder, $arrayDatas) {
      if($arrayDatas['user']->hasPermissionTo('create_categories')) {
          $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/posts?lang='. $arrayDatas['lang'] : '/admin/posts', '<i class="ni ni-single-copy-04"></i> '.__('admin.posts.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
          // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
      }
   }
}
