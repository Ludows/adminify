<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicModel;
class Url extends ClassicModel
{
    protected $table = 'urls';
    // use HasFactory;
    // use Helpers;
    
    protected $fillable = [
        'from_model',
        'from_model_id',
        'model_name',
        'model_id', 
    ];
}
