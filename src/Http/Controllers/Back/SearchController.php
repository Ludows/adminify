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

        $labels = [];
        
        if($config) {
            
            foreach ($config['models'] as $nameModel => $classModel) {
                # code...
                $m_str = get_site_key($classModel);
                $m = new $m_str();

                $labels[$nameModel] = $m->searchable_label;

                $searchResults->registerModel($m_str, $m->searchable_label );
            }

            $searchResults->limitAspectResults($config['limit']);

        }

        $searchResults = $searchResults->search($request->input( $config['name'] ));

        $a = [
            'response' => $searchResults->groupByType(),
            'count' => $searchResults->count(),
            'status' => 'OK',
            'labels' => $labels
        ];

        return response()->json($a);
    }
}
