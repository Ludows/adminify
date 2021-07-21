<?php

namespace Ludows\Adminify\Traits;
use Kris\LaravelFormBuilder\FormBuilder;


trait Listable
  {
    public $listing_column = 'title';
    public function getTableListing() {}
    public function getColumnsListing() {
        return [];
    }
  }
