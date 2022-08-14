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
    public function themeAssets($folder, $filename) {
        $theme = theme();
        if(empty($theme)) {
            throw new Error('No theme provided in resolving file', 500);
        }

        $path = theme_path().DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$filename;
        // $path = app_path() .  '/app/uploads/' . $filename;

        if(!File::exists($path)) {
            return abort(404, 'Image not found');
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = response()->make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
