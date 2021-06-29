<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;
use Ludows\Adminify\Forms\DeleteCrud;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use Illuminate\Support\Str;
class ListingController extends Controller
{
    public function index(Request $request, FormBuilder $formBuilder) {


        $config = config('site-settings.listings');

        $datas = $request->all();

        $m = new $config['search'][$datas['singular']]['class']();
        $is_multilang_model = is_translatable_model($m);
        $lang = lang();

        $columns = $m->getFillable();

        if($config['searchType'] == 'fillable') {
            $searchColumns = $m->getFillable();
        }
        else {
            $searchColumns = $config['search'][$datas['singular']]['columns'];
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
                if($is_multilang_model) {
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
        

        $m = $m->take( $config['limit'] );

        $results = $m->get();

        $actions = array();
        foreach ($results as $result) {
            # code...
            $actionable = $config['search'][$datas['singular']]['actionable'];

            $actions[] = new $actionable($result, [
                    'form' => $formBuilder->create(DeleteCrud::class, [
                    'method' => 'DELETE',
                    'url' => route( Str::plural($datas['singular']). '.destroy', [ $datas['singular'] => $result->id])
                ])
            ]);
        }

        $v = view('adminify::layouts.admin.index.blocks.datalist', ['actions' => $actions, 'datas' => $results, 'thead' => $columns, 'name' => Str::plural($datas['singular']) ])->render();


        $a = [
            'html' => $v,
            'isEnd' => isset($datas['offset']) && ($datas['offset'] + $results->count()) >= $datas['maxItems'] ? true : false,
            'response' => $results,
            'count' => $results->count(),
            'status' => 'OK',
        ];

        return response()->json($a);
    }
}
