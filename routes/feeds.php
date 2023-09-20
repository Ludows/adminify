<?php
use Illuminate\Support\Facades\Route;

Route::feeds();

$path_admin_file = base_path('routes/adminify_feeds.php');

if(file_exists($path_admin_file)){
    include($path_admin_file);
}
