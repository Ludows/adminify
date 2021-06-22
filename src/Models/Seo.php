<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;


class Seo extends Model
{
    use HasFactory;
    use HasTranslations;
    use Helpers;
    use MultilangTranslatableSwitch;

    public $MultilangTranslatableSwitch = ['data'];

    protected $table = 'seo';

    protected $fillable = [
        'model_name',
        'model_id',
        'type',
        'data',
    ];


    public function scopeType($query, $type) {
        return $query->where('type', $type);
    }
    public function scopeModelId($query, $id) {
        return $query->where('model_id', $id);
    }
    public function scopeModelName($query, $class) {
        return $query->where('model_name', $class);
    }
}
