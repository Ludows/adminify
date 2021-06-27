<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Ludows\Adminify\Actions\Translations;
use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function index(Request $request) {


        $config = config('site-settings.searchable.admin');

        $searchResults = (new Search());
        
        if($config) {
            
            foreach ($config['models'] as $nameModel => $classModel) {
                # code...
                $searchResults->registerModel($classModel, $config['labels'][$nameModel] );
            }

            $searchResults->limitAspectResults($config['limit']);

            $searchResults->search($request->input( $config['name'] ));
        }

        $a = [
            'response' => $searchResults->groupByType(),
            'count' => $searchResults->count(),
            'status' => 'OK',
            'labels' => $config['labels']
        ];

        return response()->json($a);
    }
}
