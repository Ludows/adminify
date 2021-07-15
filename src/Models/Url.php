<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Ludows\Adminify\Traits\Helpers;
class Url extends Model
{
    protected $table = 'urls';
    use HasFactory;
    use Helpers;
    
    protected $fillable = [
        'from_model',
        'from_model_id',
        'model_name',
        'model_id', 
    ];
}