<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;
use Spatie\Searchable\Search;

use File;

class SearchController extends Controller
{
    public function index(Request $request) {


        $config = get_site_key('searchable.admin');

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

        $pathModels = app_path('Models');

        $files = File::files($pathModels);

        $namespaceBase = 'App\Models';

        $a = [];

        $groups = array_keys( get_site_key('searchable') );

        foreach($files as $f){
            $namedClass = str_replace('.'.$f->getExtension(), '', $f->getBaseName());
            // dd($namedClass);

            $fullModelClass = $namespaceBase . '\\'. $namedClass;
            $m = app($fullModelClass);

            if($m->enable_searchable) {
                $groups_model = $m->groups_searchable;
                foreach ($groups_model as $group) {
                    # code...
                    if(in_array($group, $groups)) {
                        $a[] = $fullModelClass;
                    }
                }

            }
        }

        return $a;
    }
}
