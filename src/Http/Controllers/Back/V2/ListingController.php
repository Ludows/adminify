<?php

namespace Ludows\Adminify\Http\Controllers\Back\V2;

use Illuminate\Http\Request;
use App\Adminify\Http\Controllers\Controller;

class ListingController extends Controller
{
    public function showIndexPage(Request $request) {

        // @todo in table manager method search
        $datas = $request->all();

        $m_str = model($datas['singular'], false);

        if(empty($m_str)) {
            abort(403);
        }
        
        $TableManager = adminify_get_class($datas['table'], ['app:adminify:tables', 'app:tables'], false);
        
        $table = new $TableManager(); // for disable autohandling
        //render only listing not entierely table
        $rows = $table->setSearch($datas)->toArray();


        $a = [
            'datas' => $rows,
        ];

        return response()->json($a);
    }
}
