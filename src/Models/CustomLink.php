<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Ludows\Adminify\Traits\SlugUpdate;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\Urlable;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;

class CustomLink extends Model
{
    use HasFactory;
    use SlugUpdate;
    use Urlable;
    use HasTranslations;
    use Helpers;
    use MultilangTranslatableSwitch;

    protected $table = 'custom_links';

    public $MultilangTranslatableSwitch = ['title', 'slug'];

    protected $fillable = [
        'title',
        'slug',
    ];
}
