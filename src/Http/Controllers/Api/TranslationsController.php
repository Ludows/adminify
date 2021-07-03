<?php

namespace Ludows\Adminify\Http\Controllers\Api;

use App\Models\Translations;
use App\Repositories\TranslationRepository;
use Ludows\Adminify\Http\Controllers\Controller;
use Ludows\Adminify\Http\Requests\CreateTranslation;


use Illuminate\Http\Request;

class TranslationsController extends Controller
{
    private $TranslationsRepository;

    public function __construct(TranslationRepository $TranslationsRepository)
    {
        $this->middleware('auth:sanctum', ['except' => ['index','show']]);
        $this->TranslationsRepository = $TranslationsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Translations::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTranslation $request)
    {
        //
        $model = $this->TranslationsRepository->create($request->all(), $request);
        
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
        return $Translations;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Translations $Translations)
    {
        //
        $model = $this->TranslationsRepository->update($request->all(), $request, $Translations);
        
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
        $m = $Translations;

        $this->TranslationsRepository->delete($Translations);
        
        return response()->json([
            'entry' => $m,
            'message' => __('admin.success_entry_deleted'),
            'status' => 'OK'
        ]);
    }
}