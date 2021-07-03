<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;


use App\Models\Page;

class Settings extends Model
{
    use HasFactory;
    use HasTranslations;
    use MultilangTranslatableSwitch;
    use Helpers;
    public $MultilangTranslatableSwitch = ['data'];

    protected $fillable = [
        'type',
        'data',
    ];
    public function page() {
        return $this->belongsTo(Page::class, 'data', 'id');
    }
}
