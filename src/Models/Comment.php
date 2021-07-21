<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicModel;

class Comment extends ClassicModel
{
    protected $table = 'comments';

    public $MultilangTranslatableSwitch = ['comment'];

    protected $fillable = [
        'comment',
        'parent_id',
        'user_id',
        'post_id',
        'is_moderated',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRoot($query) {
        return $query->where('parent_id', 0);
    }

    public function scopeWithPostId($query, $post_id) {
        return $query->where('post_id', $post_id);
    }

    public function scopeSublevel($query, $sublevel) {
        return $query->where('parent_id', $sublevel);
    }

    public function getHasSublevelAttribute() {
        $has = false;
        $subs = $this->Sublevel($this->id)->get();
        if(count($subs->all()) > 0) {
            $has = true;
        }
        return $has;
    }

    public function scopeSublevelAll($query, $sublevel) {
        return $query->where('parent_id', '!=', $sublevel);
    }

    public function scopeApproved($query) {
        return $query->where('is_moderated', 1);
    }
}
