<?php

namespace Ludows\Adminify\Models;

use App\Models\Page;

use ClassicModel;

class Settings extends ClassicModel
{
    public $MultilangTranslatableSwitch = ['data'];

    protected $fillable = [
        'type',
        'data',
    ];
    public function page() {
        return $this->belongsTo(Page::class, 'data', 'id');
    }
}
