<?php

namespace Ludows\Adminify\Libs;

use Closure;
use Error;
use Kris\LaravelFormBuilder\Form;

class BaseForm extends Form {
    public $appendMetas = [];
    public function addSubmit($options = []) {
        $r = $this->getRequest();

        $defaults = ['label' => !$r->isEdit ? __('admin.form.create') : __('admin.form.edit'), 'attr' => ['class' => 'btn btn-default']];

        $this->add('submit', 'submit', array_merge($defaults, $options));
        
        return $this;
    }
    public function addStatuses($name = '', $options = []) {
        $hydrator = $this->getStatuses();
        $m = $this->getModel();
        $defaults = [
            'choices' => $hydrator,
            'selected' => !empty($m->{$name}) ? $m->{$name} : '',
        ];

        $this->add($name, 'select2', array_merge($defaults, $options));
        return $this;
    }
    public function addRoles($name = '', $options = []) {
        $hydrator = $this->getRoles();
        $m = $this->getModel();
        $defaults = [
            'choices' => $hydrator,
            'selected' => !empty($m->{$name}) ? $m->{$name} : '',
        ];

        $this->add($name, 'select2', array_merge($defaults, $options));
        return $this;
    }
    public function addTags($name = '', $options = []) {
        $hydrator = $this->getTags();
        $m = $this->getModel();
        $defaults = [
            'choices' => $hydrator,
            'selected' => !empty($m->{$name}) ? $m->{$name} : '',
        ];

        $this->add($name, 'select2', array_merge($defaults, $options));
    }
    public function addPages($name = '', $options = []) {
        $hydrator = $this->getPages();
        $m = $this->getModel();
        $defaults = [
            'choices' => $hydrator,
            'selected' => !empty($m->{$name}) ? $m->{$name} : '',
        ];

        $this->add($name, 'select2', array_merge($defaults, $options));
        return $this;
    }
    public function addPosts($name = '', $options = []) {
        $hydrator = $this->getPosts();
        $m = $this->getModel();
        $defaults = [
            'choices' => $hydrator,
            'selected' => !empty($m->{$name}) ? $m->{$name} : '',
        ];

        $this->add($name, 'select2', array_merge($defaults, $options));
        return $this;
    }
    public function addCategories($name = '', $options = []) {
        $hydrator = $this->getCategories();
        $m = $this->getModel();
        $defaults = [
            'choices' => $hydrator,
            'selected' => !empty($m->{$name}) ? $m->{$name} : '',
        ];

        $this->add($name, 'select2', array_merge($defaults, $options));
        return $this;
    }
    public function addUserId($name = 'user_id', $options = []) {

        $defaults = [
            'value' => user()->id
        ];
        
        $this->add($name, 'hidden', array_merge($defaults, $options));

        return $this;
    }
    public function addVisualEditor($name = '', $options = []) {

        $defaults = [
            'label_show' => false,
        ];

        $this->add($name, 'visual_editor', array_merge($defaults, $options));

        return $this;
    }
    public function addMediaLibraryPicker($name = 'media_id', $options = []) {
        
        $defaults = [
            'label_show' => false,
        ];

        $this->add($name, 'media_element', array_merge($defaults, $options));

        return $this;
    }
    public function addJodit($name = '', $options = []) {

        $defaults = [
            
        ];

        $this->add($name, 'jodit', array_merge($defaults, $options));

        return $this;
    }
    public function getStatuses() {
        $hasModel = $this->getModel();
        $statuses = app('App\Adminify\Models\Statuses')->where('id' , '!=', 3)->pluck('name' ,'id');
        $selecteds = [];

        $statuses = $statuses->all();

        foreach ($statuses as $statusId => $status) {
            # code...
            $statuses[$statusId] = __('admin.table.modules.statuses.'.$status);
        }
        return $statuses;
    }
    public function getRoles() {
        $request = $this->getRequest();
        $roleModel = app('App\Adminify\Models\Role');

        $user = $request->user ?? null;

        $roles = $roleModel::get()->pluck('name' ,'id');

        return $roles->toArray();
    }
    public function getPages() {
        $pages = '';
        
        $pages = app('App\Adminify\Models\Page')::get()->pluck('title' ,'id');

        return $pages->toArray();
    }
    public function getPosts() {
        $posts = '';
        
        $posts = app('App\Adminify\Models\Post')::get()->pluck('title' ,'id');

        return $posts->toArray();
    }
    public function getCategories() {
        $cats = '';
        
        $cats = app('App\Adminify\Models\Category')::get()->pluck('title' ,'id');

        return $cats->toArray();
    }
    public function getTags() {
        $hasModel = $this->getModel();
        $tags = app('App\Adminify\Models\Tag')::get()->pluck('title' ,'id');

        return $tags->toArray();
    }
    public function getFeaturesSite() {
        return get_site_key('enables_features');
    }
    public function loadMetas($mixed) {
        if(is_string($mixed)) {
            $theClass = adminify_get_class($mixed, ['app:metas'], false);
            $this->appendMetas($theClass);
        }
        if(is_array($mixed)) {
            foreach ($mixed as $key => $mixedItem) {
                # code...
                $theClass = adminify_get_class($mixedItem, ['app:metas'], false);
                $this->appendMetas($theClass);
            }
        }
        return $this;
    }
    private function appendMetas($theClass = '') {
        $request = request();
        $showGroup = true;
        $metaboxes = [];
        if(empty($theClass)) {
            throw new Error('You must provide a class string for '. get_class($this));
        }

        if(!empty($theClass)) {
            $metaClass = app()->make($theClass);
        }

        if((bool) $metaClass->allow_filtering) {
            $showGroup = $metaClass->showGroup( !empty($request->model) ? $request->model : [] );
        }
        if($showGroup) {
            $metabox_key = '_metabox_'.uuid(20);
            $metaboxes[] = $metabox_key;
            $this->add($metabox_key, $metaClass->getTypeField(), array_merge($metaClass->getDefaults(), [
                'label' => $metaClass->getMetaboxTitle(),
                'model' => !empty($request->model) ? $request->model : [],
                'wrapper' => [
                    'id' => $metabox_key,
                ],
                'options' => [    // these are options for a single type
                    'class' => $theClass,
                    'label' => false,
                ]
            ]));
        }

        if(!empty($metaboxes)) {
            // we retrieve all metaboxes attached to page. now link in the form for register in db
            $this->add('_metaboxes', 'hidden', [
                'value' => implode(', ', $metaboxes)
            ]);
        }
    }
}
