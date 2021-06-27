<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Ludows\Adminify\Actions\Translations;
use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;
use Ludows\Adminify\Forms\DeleteCrud;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
class ListingController extends Controller
{
    public function index(Request $request, FormBuilder $formBuilder) {


        $config = config('site-settings.listings');

        $datas = $request->all();

        $m = new $config['search'][$datas['type']]['class']();

        $columns = $m->getFillable();

        if($config['searchType'] == 'fillable') {
            $searchColumns = $m->getFillable();
        }
        else {
            $searchColumns = $config['search'][$datas['type']]['columns'];
        }

        $i = 0;
        foreach ($searchColumns as $column) {
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

        $results = $m->get();

        $actions = array();
        foreach ($results as $result) {
            # code...
            $actionable = $config['search'][$datas['type']]['actionable'];

            $actions[] = new $actionable($result, [
                    'form' => $formBuilder->create(DeleteCrud::class, [
                    'method' => 'DELETE',
                    'url' => route( Str::plural($datas['singular']). '.destroy', [ $datas['singular'] => $result->id])
                ])
            ]);
        }

        

        $a = [
            'html' => view('adminify::layouts.admin.index.blocks.datalist', ['actions' => $actions, 'datas' => $results, 'thead' => $columns, 'name' => $datas['singular']]),
            'response' => $result,
            'count' => $result->count(),
            'status' => 'OK',
        ];

        return response()->json($a);
    }
}
