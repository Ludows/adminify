<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Ludows\Adminify\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ImageController extends Controller
{
    public function show(\League\Glide\Server $server, \League\Glide\Signatures\Signature $sign,  $path) {

        // Validate HTTP signature
        // $sign->validateRequest($path, $_GET);

        // $u = user();

        // dd(storage('public')->url($path), $filesystem->path('url'));

        // dd($filesystem->translateToLfmPath($path), storage('public')->getDriver()->getConfig());
        $request = request();
        $path = $request->path();
        $sign->validateRequest($path, $request->all());

        return $server->getImageResponse($path, request()->all());
    }
}
