<?php

namespace Ludows\Adminify\Http\Controllers\Front;

use Ludows\Adminify\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use League\Glide\Signatures\SignatureFactory;


class ImageController extends Controller
{
    public function show(Filesystem $filesystem, $path) {
        
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => $filesystem->getDriver(),
            'cache' => $filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url' => 'images',
            'max_image_size' => 2000*2000,
        ]);

        // Validate HTTP signature
        SignatureFactory::create(env('GLIDE_SECURE_KEY'))->validateRequest($path, $_GET);

        return $server->getImageResponse($path, request()->all());
    }
}