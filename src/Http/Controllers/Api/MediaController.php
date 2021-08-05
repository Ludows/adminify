<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Models\Media;
use App\Repositories\MediaRepository;
use Ludows\Adminify\Http\Controllers\Controller;
use App\Http\Requests\CreateMediaRequest;
use App\Http\Requests\UpdateMediaRequest;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class MediaController extends Controller
{
    private $MediaRepository;

    public function __construct(MediaRepository $MediaRepository)
    {
        $u = user();
        $this->user = $u != null ? $u : User::find(Role::GUEST);
        $this->MediaRepository = $MediaRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!$this->user->tokenCan('api:read')) {
            abort(403);
        };
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
        if(!$this->user->tokenCan('api:create')) {
            abort(403);
        };

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
        if(!$this->user->tokenCan('api:read')) {
            abort(403);
        };

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
        if(!$this->user->tokenCan('api:update')) {
            abort(403);
        };

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
        if(!$this->user->tokenCan('api:delete')) {
            abort(403);
        };

        $m = $Media;

        $this->MediaRepository->delete($Media);
        
        return response()->json([
            'entry' => $m,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}