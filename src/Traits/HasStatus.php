<?php

namespace Ludows\Adminify\Traits;

use App\Adminify\Models\Statuses;

trait HasStatus
{
    public function status() {
        return $this->HasOne(Statuses::class, 'id', 'status_id');
    }
    public function scopeStatus($query, $key, $operator = '=') {
        return $query->where('status_id', $operator, $key);
    }
    public function isPublished() {
        return $this->status_id == Statuses::PUBLISHED_ID;
    }
    public function isDrafted() {
        return $this->status_id == Statuses::DRAFTED_ID;
    }
    public function isTrashed() {
        return $this->status_id == Statuses::TRASHED_ID;
    }
}