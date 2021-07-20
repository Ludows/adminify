<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Ludows\Adminify\Traits\OnBootedModel;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;

use App\Models\Menu;
use App\Models\Media;
use Ludows\Adminify\Traits\Helpers;

class MenuItem extends Model
{
    use HasFactory;
    use OnBootedModel;
    use HasTranslations;
    use MultilangTranslatableSwitch;
    use Helpers;

    public $MultilangTranslatableSwitch = ['overwrite_title'];

    protected $fillable = [
        'model',
        'model_id',
        'overwrite_title',
        'parent_id',
        'media_id',
        'class',
        'open_new_tab'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class,'media_id', 'id');
    }

    public function menu() {
        return $this->belongsToMany(Menu::class);
    }

    public function related() {
        return $this->hasOne($this->model, 'id', 'model_id');
    }


}
