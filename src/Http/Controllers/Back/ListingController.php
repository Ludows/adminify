<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Ludows\Adminify\Actions\Translations;
use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;
use Spatie\Searchable\Search;

class ListingController extends Controller
{
    public function index(Request $request) {


        $config = config('site-settings.listings');

        $datas = $request->all();

        $m = new $config['search'][$datas['type']]['class']();

        if($config['searchType'] == 'fillable') {
            $columns = $m->getFillable();
        }
        else {
            $columns = $config['search'][$datas['type']]['columns'];
        }

        $i = 0;
        foreach ($columns as $column) {
            # code...
            if($i == 0) {
                $m->where($column, 'like',  "%" . strtolower($datas['search']) . "%");
            }
            else {
                $m->orWhere($column, 'like',  "%" . strtolower($datas['search']) . "%");
            }
            
            $i++;
        }

        $m->take( $config['limit'] );

        $result = $m->get();

        $a = [
            'response' => $result,
            'count' => $result->count(),
            'status' => 'OK',
        ];

        return response()->json($a);
    }
}
