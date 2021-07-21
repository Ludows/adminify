<?php

namespace Ludows\Adminify\Models;
use ClassicModel;

class Tag extends ClassicModel
{
    protected $table = 'tags';

    public $MultilangTranslatableSwitch = ['title','slug'];
    
    protected $fillable = [
        'title',
        'slug',
    ];
}
