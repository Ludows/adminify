<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

use App\Adminify\Models\Statuses;
class ListingController extends Controller
{
    public function index(Request $request) {


        
        $config = get_site_key('tables');

        $datas = $request->all();

        $m_str = adminify_get_class($datas['singular'], ['app:models', 'app:adminify:models'], false);

        if(empty($m_str)) {
            abort(403);
        }
        $modelBase = new $m_str();
        $m = $modelBase;
        $is_multilang_model = is_translatable_model($m);
        $useMultilang = $request->useMultilang;
        $lang = lang();

        $columns = $m->getFillable();
        $tableColumns = $m->getConnection()->getDoctrineSchemaManager()->getColumns();
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
                if( in_array($column, $tableColumns)) {
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
        }

        if(isset($datas['status']) && is_trashable_model($modelBase) && $datas['status'] != -1) {
            $m = $m->where('status_id', $datas['status']);
        }
        else if (is_trashable_model($modelBase) && $datas['status'] == -1) {
            $m = $m->status(Statuses::TRASHED_ID, '!=');
        }

        $m = $m->take( $config['limit'] );

        // if( !empty($datas['offset']) &&  intval($datas['offset']) != 0) {
        $m = $m->skip($datas['offset']);
        // }

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
