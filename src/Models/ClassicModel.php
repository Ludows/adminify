<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

// use Ludows\Adminify\Traits\OnBootedModel;
use Ludows\Adminify\Traits\AdminableMenu;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Formidable;
use Ludows\Adminify\Traits\Listable;
use Ludows\Adminify\Traits\Searchables;
use Ludows\Adminify\Traits\SavableTranslations;
use Ludows\Adminify\Traits\PathableMedia;
use Ludows\Adminify\Traits\ProcessableAssets;
use Ludows\Adminify\Traits\HasMeta;
use Ludows\Adminify\Traits\HasStatus;

use Rennokki\QueryCache\Traits\QueryCacheable;

use Spatie\Feed\Feedable;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

abstract class ClassicModel extends Model implements Searchable, Feedable
{
    use HasFactory;
    use HasMeta;
    // use OnBootedModel;
    // use Urlable;
    use HasTranslations;
    use AdminableMenu;
    use MultilangTranslatableSwitch;
    use PathableMedia;
    // use Sitemapable;
    use Helpers;
    use Formidable;
    use Listable;
    use Searchables;
    use SavableTranslations;
    use ProcessableAssets;
    use HasStatus;
    use QueryCacheable;

    public $cacheFor = 3600;

    public $cacheDriver = 'files';
    
    public function getSearchResult() : SearchResult
    {
       $tableName = $this->getTable();

       $url = route( plural($tableName).'.edit', [ singular( $tableName ) => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->{$this->searchable_label},
           $url
        );
    }
}
