<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;
use Spatie\Searchable\Search;

use File;

class SearchController extends Controller
{
    public function index(Request $request) {

        if(!empty($request->focus_search)) {
            $key = $request->focus_search;
        }
        else {
            $key = 'admin';
        }

        $config = get_site_key('searchable.'.$key);

        $searchResults = (new Search());

        $labels = [];

        $models = $this->getModels();

        if(!empty($config) && !empty($models)) {

            foreach ($models as $model) {
                # code...
                $m = new $model;

                $labels[ singular($m->getTable()) ] = $m->searchable_label;

                $searchResults->registerModel($model, $m->searchable_label );
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
    public function getModels() {

        $Models = adminify_get_classes_by_folders(['app:models', 'app:adminify:models']);

        $groups = array_keys( get_site_key('searchable') );

        foreach($Models as $Model){
            // dd($namedClass);
            $m = app($Model);

            if(property_exists($m, 'enable_searchable') && $m->enable_searchable) {
                $groups_model = $m->groups_searchable;
                foreach ($groups_model as $group) {
                    # code...
                    if(in_array($group, $groups)) {
                        $a[] = $Model;
                    }
                }

            }
        }

        return $a;
    }
}
