<?php

namespace Ludows\Adminify\Traits;
use App\Adminify\Models\Comment;

trait Commentable
  {
    protected $no_comments = false;
    public function scopeRoot($query) {
        return $query->where('parent_id', 0);
    }

    public function scopeWithModelId($query, $model_id) {
        return $query->where('model_id', $model_id);
    }

    public function scopeWithModelClass($query, $modelClass = null) {
        return $query->where('model_class', !empty($modelClass) ? $modelClass : get_class($this));
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

    public function shouldUseComment() {

        if(method_exists($this, 'defineCommentStrategy')) {
            return $this->defineCommentStrategy();
        }

        return $this->no_comments;
    }

    public function getcommentsThreeAttribute() {
        $a = [];
        $m = new Comment();
        $r = request();
        $all = $r->all();
        $items = $m->withModelId($this->id)->withModelClass( empty($all['model_class']) ? get_class( $r->model ) : $all['model_class'] )->root()->approved()->get();
        $allSubs = $m->SublevelAll(0)->approved()->get();
        $grouped = $allSubs->groupBy('parent_id');
        $i = 0;

        function checkCommentChilds($item, $subItems, $grouped) {
            if($grouped->has($item->id)) {
                $cibled = $grouped->get($item->id);
                $item->childs = $cibled;
                foreach ($cibled as $c) {
                    # code...
                    checkCommentChilds($c, $subItems, $grouped);
                }
            }
            return $item;
        }
        foreach ($items as $item) {
            # code...
            checkCommentChilds($item, $allSubs, $grouped);
            $a[$i] = $item;
            $i++;
        }
        return collect($a);
    }

  }
