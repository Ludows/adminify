<?php

namespace Ludows\Adminify\Http\Controllers;

use Ludows\Adminify\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ludows\Adminify\Models\ContentTypeModel as Model;

class ApiBaseController extends Controller
{
    public $view_key_cache_prefix = 'api_view';
    public $abilities_check = [];

    public function hasTokenCheck() {
        
    }
}
