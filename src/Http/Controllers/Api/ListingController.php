<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use Ludows\Adminify\Http\Controllers\Controller;


use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $output = '';
        Artisan::call('route:list', array(
            '--path' => 'api',
            '--json' => true
        ));
        $output .= Artisan::output();

        return $output;
    }
}