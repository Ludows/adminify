<?php

namespace Ludows\Adminify\Traits;

trait HasInteractsWithFront
  {
    public $enables = [
        'archive' => false,
        'category' => false,
        'tag' => false,
    ];

    public $routeVerbs = [
        'archive' => [
            'fr' => 'archives',
            'en' => 'archives'
        ],
        'category' => [
            'fr' => 'categories',
            'en' => 'categories'
        ],
        'tag' => [
            'fr' => 'etiquettes',
            'en' => 'tags'
        ],
    ];

    public function getKeyFrontAttribute($key) {}

    public function shouldUseArchive() {
        if(method_exists($this, 'defineArchiveStrategy') && $this->enables['archive'] == true) {
            return $this->defineArchiveStrategy();
        }

        return $this->enables['archive'];
    }
    public function shouldUseCategory() {
        if(method_exists($this, 'defineCategoryStrategy') && $this->enables['category'] == true) {
            return $this->defineCategoryStrategy();
        }

        return $this->enables['category'];
    }
    public function shouldUseTag() {
        if(method_exists($this, 'defineTagStrategy') && $this->enables['tag'] == true) {
            return $this->defineTagStrategy();
        }

        return $this->enables['tag'];
    }
  }
