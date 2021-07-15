<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use Ludows\Adminify\Http\Controllers\Controller;
use App\Forms\DeleteCrud;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use Illuminate\Support\Str;
class ListingController extends Controller
{
    public function index(Request $request, FormBuilder $formBuilder) {


        $config = config('site-settings.listings');

        $datas = $request->all();

        $m_str = get_site_key($config['search'][$datas['singular']]['class']);
        $m = new $m_str();
        $is_multilang_model = is_translatable_model($m);
        $useMultilang = $request->useMultilang;
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
                if($is_multilang_model && $useMultilang) {
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


        $TableManager = $config['search'][$datas['singular']]['tableManager'];

        $table = new $TableManager(false); // for disable autohandling
        $table->datas('results', $results); 
        $table->handle();

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
