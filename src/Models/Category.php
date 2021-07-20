<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Media;

use Ludows\Adminify\Traits\SlugUpdate;
use Ludows\Adminify\Traits\Urlable;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Sitemapable;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class Category extends Model implements Searchable
{
    use HasFactory;
    use SlugUpdate;
    use Urlable;
    use HasTranslations;
    use MultilangTranslatableSwitch;
    use Sitemapable;
    use Helpers;

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
