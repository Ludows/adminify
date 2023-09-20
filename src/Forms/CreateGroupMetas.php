<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Support\Facades\Route;


class CreateGroupMetas extends BaseForm
{
    public function buildForm()
    {
        $arrayOfRoutesNames = array();
        $selectedsRoutes = array();
        $routeCollection = Route::getRoutes()->get();
        $excludes = get_site_key('metas.excludesOn');
        $m = $this->getModel();
        $routesInDb = [];

        if(!empty($m)) {
            $routesInDb = explode(',',$m->views_name);
        }

        // dd($this->getModel());

        foreach ($routeCollection as $route) {
            # code...
            $routeName = $route->getName();
            if(startsWith($route->uri, 'admin') && !containsIn($routeName, $excludes) ) {
                $arrayOfRoutesNames[$routeName] = __('admin.form.routes.'.$routeName);
                if(!empty($m) && in_array($routeName, $routesInDb)) {
                    $selectedsRoutes[] = $routeName;
                }
            }
        }

        // dd($this->getRequest());

        $this
            ->add('title', Field::TEXT, [
                'label_show' => false,
                'attr' => ['placeholder' =>  __('admin.form.title') ],
            ]);

        $this
            ->add('named_class', 'select2', [
                'empty_value' => __('admin.form.select_named_class'),
                'choices' => adminify_get_classes_by_folders(['app:metas', 'app:adminify:metas']),
                'selected' => !empty($m) ? $m->named_class : '',
                'label' => __('admin.form.select_named_class'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_named_class'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ]);

        $this
            ->add('views_name', 'select2', [
                'empty_value' => __('admin.form.select_routes'),
                'choices' => $arrayOfRoutesNames,
                'selected' => $selectedsRoutes,
                'attr' => [
                    'multiple' => 'multiple'
                ],
                'label' => __('admin.form.select_routes'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_routes'),
                    'multiple' => true,
                    'width' => '100%'
                ]
            ]);
        
        $this->add('allow_filtering', 'checkbox', [
            'label_show' => true,
            'label' => __('admin.form.allow_filtering'),
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input'],
            'label_attr' => ['class' => 'custom-control-label'],
        ]);

       
        $this->add('uuid', 'hidden', [
            'value' => 'metabox-'.uuid(15)
        ]);

        $this->addUserId('user_id', []);

        $this->addSubmit();
    }
}
