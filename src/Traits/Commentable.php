<?php

namespace Ludows\Adminify\Traits;
use App\Adminify\Models\Comment;

trait Commentable
  {
    public function scopeRoot($query) {
        return $query->where('parent_id', 0);
    }

    public function scopeWithModelId($query, $model_id) {
        return $query->where('model_id', $model_id);
    }

    public function scopeWithModelClass($query, $modelClass) {
        return $query->where('model_class', $modelClass ?? get_class($this));
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

    public function getcommentsThreeAttribute() {
        $a = [];
        $m = new Comment();
        $items = $m->withModelId($this->id)->withModelClass()->root()->approved()->get();
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
