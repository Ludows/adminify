<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;

use Ludows\Adminify\Traits\Helpers;

class Tag extends Model
{
    protected $table = 'tags';
    use HasFactory;
    use HasTranslations;
    use Helpers;
    use MultilangTranslatableSwitch;

    public $MultilangTranslatableSwitch = ['title','slug'];
    
    protected $fillable = [
        'title',
        'slug',
    ];
}
