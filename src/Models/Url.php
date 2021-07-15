<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;

use Ludows\Adminify\Traits\Helpers;
class Url extends Model
{
    protected $table = 'urls';
    use HasFactory;
    use HasTranslations;
    use MultilangTranslatableSwitch;
    use Helpers;
    
    public $MultilangTranslatableSwitch = ['data'];

    protected $fillable = [
        'model_name',
        'model_id', //the path you uploaded the image
        'data',
    ];
}
