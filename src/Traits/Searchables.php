<?php

namespace Ludows\Adminify\Traits;
use Kris\LaravelFormBuilder\FormBuilder;


trait Searchables
  {
   public $enable_searchable = true;
   public $searchable_label = 'title';
   public $groups_searchable = ['admin']; //default register in admin
  }
