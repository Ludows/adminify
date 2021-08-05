<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Models\Media;
use App\Repositories\MediaRepository;
use Ludows\Adminify\Http\Controllers\Controller;
use App\Http\Requests\CreateMediaRequest;
use App\Http\Requests\UpdateMediaRequest;


use Illuminate\Http\Request;

class MediaController extends Controller
{
    private $MediaRepository;

    public function __construct(MediaRepository $MediaRepository)
    {
        $this->MediaRepository = $MediaRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Media::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMediaRequest $request)
    {
        //
        $model = $this->MediaRepository->create($request->all(), $request);
        
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
    public function show(Media $Media)
    {
        return $Media;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMediaRequest $request, Media $Media)
    {
        //
        $model = $this->MediaRepository->update($request->all(), $request, $Media);
        
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
    public function destroy(Media $Media)
    {
        //
        $m = $Media;

        $this->MediaRepository->delete($Media);
        
        return response()->json([
            'entry' => $m,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}