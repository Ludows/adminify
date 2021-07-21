<?php

namespace Ludows\Adminify\Traits;
use Kris\LaravelFormBuilder\FormBuilder;


trait Listable
  {
    public function getTableListing() {}
    public function getColumnsListing() {
        return [];
    }
  }
