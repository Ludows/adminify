<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;

use App\Models\Statuses;
class ListingController extends Controller
{
    public function index(Request $request) {


        $config = config('site-settings.listings');

        $datas = $request->all();

        $m_str = get_site_key($config['search'][$datas['singular']]);
        $m = new $m_str();
        $is_multilang_model = is_translatable_model($m);
        $useMultilang = $request->useMultilang;
        $lang = lang();

        $columns = $m->getFillable();
        $TableManager = $m->getTableListing();
        $translatableFields = [];
        if($is_multilang_model) {
            $translatableFields = $m->translatable;
        }

        if($config['searchType'] == 'fillable') {
            $searchColumns = $m->getFillable();
        }
        else {
            $searchColumns = $m->getColumnsListing();
        }

        $search = null;
        if(isset($datas['search'])) {
            $search = $datas['search'];
        }

        if($search != null) {
            $i = 0;
            foreach ($searchColumns as $column) {
                # code...
                $binding = null;
                if($is_multilang_model && $useMultilang && in_array($column , $translatableFields)) {
                    $binding = $column.'->'.$lang;
                }
                else {
                    $binding = $column;
                }

                if($i == 0) {
                    $m = $m->where($binding, 'like',  "%" . strtolower($search) . "%");
                }
                else {
                    $m = $m->orWhere($binding, 'like',  "%" . strtolower($search) . "%");
                }
                
                $i++;
            }
        } 

        if(isset($datas['status']) && is_trashable_model($m) && $datas['status'] != -1) {
            $m = $m->where('status_id', $datas['status']);
        }
        else {
            $m = $m->status(Statuses::TRASHED_ID, '!=');
        }

        $m = $m->take( $config['limit'] );

        $results = $m->get();


        // $TableManager = $m->getTableListing();

        $table = new $TableManager(); // for disable autohandling
        $table->datas('results', $results); 

        //render only listing not entierely table
        $v = $table->list();


        $a = [
            'html' => $v->render(),
            'isEnd' => isset($datas['offset']) && ($datas['offset'] + $results->count()) >= $datas['maxItems'] ? true : false,
            'response' => $results,
            'count' => $results->count(),
            'status' => 'OK',
        ];

        return response()->json($a);
    }
}
