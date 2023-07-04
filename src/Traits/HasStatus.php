<?php

namespace Ludows\Adminify\Traits;

use App\Adminify\Models\Statuses;

trait HasStatus
{
    public $status_key = 'status_id';
    public function status() {
        return $this->HasOne(Statuses::class, 'id', $this->status_key);
    }
    public function scopeWithStatus($query, $key, $operator = '=') {
        return $query->where($this->status_key, $operator, $key);
    }
    public function isPublished() {
        return $this->{$this->status_key} == Statuses::PUBLISHED_ID;
    }
    public function isDrafted() {
        return $this->{$this->status_key} == Statuses::DRAFTED_ID;
    }
    public function isTrashed() {
        return $this->{$this->status_key} == Statuses::TRASHED_ID;
    }
    public function getStatusAttribute() {

        $the_value = $this->{$this->status_key};
        if(empty($the_value)) {
            return [];
        }

        return model('Statuses')->where('id', $the_value)->first();
    }
}