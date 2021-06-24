<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Ludows\Adminify\Actions\Translations;
use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function index(Request $request) {
        $searchResults = (new Search())
            ->registerModel(\Ludows\Adminify\Models\User::class, 'name')
            ->registerModel(\Ludows\Adminify\Models\Category::class, 'title')
            ->registerModel(\Ludows\Adminify\Models\Menu::class, 'title')
            ->registerModel(\Ludows\Adminify\Models\Page::class, 'title')
            ->registerModel(\Ludows\Adminify\Models\Post::class, 'title')
            ->registerModel(\Ludows\Adminify\Models\Translations::class, 'text')
            ->limitAspectResults(5)
            ->search($request->input('query'));

        return response()->json([
            'response' => $searchResults->groupByType(),
            'count' => $searchResults->count(),
            'labels' => [
                'posts' => 'title',
                'users' => 'name',
                'menus' => 'title',
                'pages' => 'title',
                'traductions' => 'key'
            ],
            'status' => 'OK'
        ]);
    }
}
