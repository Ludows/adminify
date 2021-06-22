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
            ->registerModel(\App\Models\User::class, 'name')
            ->registerModel(\App\Models\Category::class, 'title')
            ->registerModel(\App\Models\Menu::class, 'title')
            ->registerModel(\App\Models\Page::class, 'title')
            ->registerModel(\App\Models\Post::class, 'title')
            ->registerModel(\App\Models\Traduction::class, 'text')
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
