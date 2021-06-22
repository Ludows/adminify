<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Forms\UpdateMediaLibrary;
use App\Forms\CreateCategory;
use Kris\LaravelFormBuilder\FormBuilder;


class RequiredForms
{
    private $formBuilder;
    function __construct(FormBuilder $FormBuilder) {
        $this->formBuilder = $FormBuilder;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $forms = array(
            'updateMediaLibrary' => array(
                'class' => UpdateMediaLibrary::class,
                'options' => [
                    'method' => 'PUT',
                    'action' => null
                ]
            ),
            'createCategory' => array(
                'class' => CreateCategory::class,
                'options' => [
                    'method' => 'POST',
                    'url' => route('categories.store')
                ]
            )
        );

        // $formBuilder->create(\App\Forms\DeleteMedia::class, [
        //     'method' => 'DELETE',
        //     'url' => route('medias.destroy', ['media' => $media->id])
        // ]);

        foreach ($forms as $key => $form) {
            # code...
            view()->share($key, $this->formBuilder->create($form['class'], $form['options']));
            // dd($form);
        }
        return $next($request);
    }
}
