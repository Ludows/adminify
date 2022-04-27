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
        $schemaBuilder = $m->getConnection()->getSchemaBuilder();
        $TableManager = adminify_get_class($datas['table'], ['app:tables', 'app:adminify:tables'], false);
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
        if(!empty($datas['search'])) {
            $search = $datas['search'];
        }
        $keys = [];
        $restrictedBindings = ['title', 'slug'];

        if(isset($datas['status']) && is_trashable_model($modelBase) && $datas['status'] != -1) {
            $m = $m->where($modelBase->status_key, $datas['status']);
        }

        else if (is_trashable_model($modelBase) && $datas['status'] == -1) {
            $m = $m->where($modelBase->status_key, '!=', Statuses::TRASHED_ID);
        }

        if($search != null) {
            $i = 0;
            foreach ($searchColumns as $column) {
                # code...
                if( $schemaBuilder->hasColumn($modelBase->getTable(), $column) && $column != $modelBase->status_key  ) {
                    $binding = null;
                    if($is_multilang_model && $useMultilang && in_array($column , $translatableFields)) {
                        $binding = $column.'->'.$lang;
                    }
                    else {
                        $binding = $column;
                    }

                    if(in_array($binding, $restrictedBindings)) {
                       $m = $m->where($binding, 'like',  "%" . $search . "%");
                    }
                    else {
                        $m = $m->orWhere($binding, 'like',  "%" . $search . "%");
                    }

                    $keys[] = $binding;

                    $i++;
                }
            }
        }



        $m = $m->take( $config['limit'] );

        // if( !empty($datas['offset']) &&  intval($datas['offset']) != 0) {
        $m = $m->skip($datas['offset']);
        // }


        $results = $m->dontCache()->get();

        // dd($keys, $m->toSql(), $m->getBindings(), $results, $search);


        // $TableManager = $m->getTableListing();

        $table = new $TableManager(); // for disable autohandling
        $table->datas('results', $results);

        //render only listing not entierely table
        $v = $table->list();

        $defaultEnd =  ($datas['offset'] + $results->count()) >= $datas['maxItems'];

        // if(!empty($search)) {
            if($results->count() < $datas['limit']) {
                $defaultEnd = $results->count() < $datas['limit'];
            }
        // }


        $a = [
            'html' => $v->render(),
            // 'isEnd' => isset($datas['offset']) && ($datas['offset'] + $results->count()) >= $datas['maxItems'] ? true : false,
            'isEnd' => $defaultEnd,
            'response' => $results,
            'count' => $results->count(),
            'status' => 'OK',
        ];

        return response()->json($a);
    }
}
