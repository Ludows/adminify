<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Ludows\Adminify\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;
class ImageController extends Controller
{
    public function show(\League\Glide\Server $server, \League\Glide\Signatures\Signature $sign,  $path) {
        $request = request();
        $path = $request->path();
        $sign->validateRequest($path, $request->all());

        return $server->getImageResponse($path, request()->all());
    }
}
