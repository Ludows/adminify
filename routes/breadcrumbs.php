<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('page', function (BreadcrumbTrail $trail, $model) {
    $trail->push('Accueil', '/');
    $urls = $model->url;
    foreach ($urls as $url) {
        # code...
        $trail->push( \Str::studly($url) , $url);
    }
});

Breadcrumbs::for('post', function (BreadcrumbTrail $trail, $model) {
    $trail->push('Accueil', '/');
    $blogpage = setting('blogpage');
    if(!empty($blogpage)) {
       $page = model('Page')->find($blogpage);
       $trail->push($page->title, $page->slug);
    }
    $urls = $model->url;
    foreach ($urls as $url) {
        # code...
        $trail->push( \Str::studly($url) , $url);
    }
});