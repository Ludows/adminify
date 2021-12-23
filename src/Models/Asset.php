<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicModel;

class Asset extends ClassicModel
{
    public $enable_searchable = false;

    protected $table = 'assets';

    protected $fillable = [
        'entity_id',
        'type',
        'model',
        'data',
    ];

    public function scopeType($query, $key, $operator = '=') {
        return $query->where('type', $operator, $key);
    }

    public function scopeModel($query, $key, $operator = '=') {
        return $query->where('model', $operator, $key);
    }

    public function scopeId($query, $key, $operator = '=') {
        return $query->where('entity_id', $operator, $key);
    }

    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [
      'entity_id' => NULL,
      'type' => '',
      'model' => '',
      'data' => '{}',
   ];
}
