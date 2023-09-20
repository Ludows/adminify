<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Adminify\Models\Translations;
use App\Adminify\Repositories\TranslationRepository;
use Ludows\Adminify\Http\Controllers\Controller;
use App\Adminify\Http\Requests\CreateTranslationRequest;
use App\Adminify\Http\Requests\UpdateTranslationRequest;


use Illuminate\Http\Request;
use App\Adminify\Models\User;
use App\Adminify\Models\Role;

class TranslationsController extends Controller
{
    private $TranslationsRepository;

    public function __construct(TranslationRepository $TranslationsRepository)
    {
        $this->middleware(function ($request, $next) {
            $u = user();
            $this->user = $u != null ? $u : User::find(Role::GUEST);
    
            return $next($request);
        });
        $this->TranslationsRepository = $TranslationsRepository;
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
        return Translations::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTranslationRequest $request)
    {
        //
        if(!$this->user->tokenCan('api:create')) {
            abort(403);
        };

        $model = $this->TranslationsRepository->addModel(new Translations())->create($request->all());
        
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
    public function show(Translations $Translations)
    {
        if(!$this->user->tokenCan('api:read')) {
            abort(403);
        };

        return $Translations;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTranslationRequest $request, Translations $Translations)
    {
        //
        if(!$this->user->tokenCan('api:update')) {
            abort(403);
        };

        $model = $this->TranslationsRepository->addModel($Translations)->update($request->all(), $Translations);
        
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
    public function destroy(Translations $Translations)
    {
        //
        if(!$this->user->tokenCan('api:delete')) {
            abort(403);
        };
        
        $m = $Translations;

        $this->TranslationsRepository->addModel($Translations)->delete($Translations);
        
        return response()->json([
            'entry' => $m,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}