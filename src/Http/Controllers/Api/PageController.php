<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Models\Page;
use App\Repositories\PageRepository;
use Ludows\Adminify\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;


use Illuminate\Http\Request;

class PageController extends Controller
{
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->middleware('auth:sanctum', ['except' => ['index','show']]);
        $this->pageRepository = $pageRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Page::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        //
        $model = $this->pageRepository->create($request->all(), $request);
        
        return response()->json([
            'entry' => $model,
            'message' => __('admin.success_entry_created'),
            'status' => 'OK'
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return $page;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
        //
        $model = $this->pageRepository->update($request->all(), $request, $page);
        
        return response()->json([
            'entry' => $model,
            'message' => __('admin.success_entry_updated'),
            'status' => 'OK'
        ]);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
        $m = $page;

        $this->pageRepository->delete($page);
        
        return response()->json([
            'entry' => $m,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}