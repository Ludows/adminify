<?php

namespace Ludows\Adminify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Forms\UpdateMediaLibrary;
use App\Forms\CreateCategory;
use App\Forms\CreateTag;
use App\Forms\SelectTemplate;
use App\Forms\SaveTemplate;
use Kris\LaravelFormBuilder\FormBuilder;


class RequiredForms
{
    private $formBuilder;
    function __construct(FormBuilder $FormBuilder) {
        $this->formBuilder = $FormBuilder;
    }

    public function forms() {
        return array(
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
                ),
            'createTag' => array(
                'class' => CreateTag::class,
                'options' => [
                    'method' => 'POST',
                    'url' => route('tags.store')
                ]
            ),
            'selectTemplate' => array(
                'class' => SelectTemplate::class,
                'options' => [
                    'method' => 'POST',
                    'url' => '#'
                ]
                ),
                'saveTemplate' => array(
                    'class' => SaveTemplate::class,
                    'options' => [
                        'method' => 'POST',
                        'url' => route('templates.store')
                    ]
                )
        );
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
        $forms = $this->forms();

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
