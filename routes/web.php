<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Register Auth routes ..
require_once('auth.php');

// Register Admin Routes..
require_once('admin.php');

require_once('front.php');
// require_once('no-multilang.php');


