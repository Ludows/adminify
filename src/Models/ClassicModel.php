<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Ludows\Adminify\Traits\OnBootedModel;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;

use Spatie\Feed\Feedable;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Feed\FeedItem;

abstract class ClassicModel extends Model implements Searchable, Feedable
{
    use HasFactory;
    use OnBootedModel;
    // use Urlable;
    use HasTranslations;
    use MultilangTranslatableSwitch;
    // use Sitemapable;
    use Helpers;
}
