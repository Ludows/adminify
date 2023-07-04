<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

use App\Adminify\Models\Statuses;
class ListingController extends Controller
{
    public function index(Request $request) {

        // @todo in table manager method search

        $config = get_site_key('tables');
        $shareds = inertia()->getShared();

        $datas = $request->all();

        $m_str = adminify_get_class($datas['singular'], ['app:models', 'app:adminify:models'], false);

        $pageInt = 1;

        if(empty($m_str)) {
            abort(403);
        }
        $modelBase = new $m_str();
        $m = $modelBase;
        $is_multilang_model = is_translatable_model($m);
        $useMultilang = $shareds['useMultilang'];
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

        if(!empty($datas['page'])) {
            $pageInt = (int) $datas['page'];
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


        $results = $m->paginate($config['limit'], $config['searchType'] == 'fillable' ? ['*'] : $m->getColumnsListing(), lowercase( $datas['singular'] ), $pageInt)->withPath( route( lowercase( plural($datas['singular']) ) .'.index') );

        // dd($keys, $m->toSql(), $m->getBindings(), $results, $search);


        // $TableManager = $m->getTableListing();

        $table = new $TableManager(); // for disable autohandling
        $table->datas('results', $results);

        //render only listing not entierely table
        $rows = $table->toArray();


        $a = [
            'datas' => $rows,
            // 'isEnd' => isset($datas['offset']) && ($datas['offset'] + $results->count()) >= $datas['maxItems'] ? true : false,
        ];

        return response()->json($a);
    }
}
