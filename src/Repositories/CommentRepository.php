<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\Comment; // Don't forget to update the model's namespace

class CommentRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Don't forget to update the model's name
        $this->model = app(Comment::class);
    }
    public function create($values) {
        $request = request();
        $multilang = $request->useMultilang;
        $lang = lang();
        $m = new Comment();

        if($multilang) {
            $multilangsFields = $m->getMultilangTranslatableSwitch();
            $fields = $m->getFieldsExceptTranslatables();
            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($values[$multilangsField])) {
                    $m->setTranslation($multilangsField, $lang, $values[$multilangsField]);
                    unset($values[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($values[$field])) {
                    $m->{$field} = $values[$field];
                }
            }

            $m->save();
        }
        else {
            $m->create($values);
        }
        return $m;
    }
    public function update($values, $model) {

        $request = request();
        $multilang = $request->useMultilang;
        $lang = lang();
        $m = $model;

        // $values = array_merge($values, [
        //     'lang' => lang()
        // ]);

        if($multilang) {
            $multilangsFields = $m->getMultilangTranslatableSwitch();
            $fields = $m->getFieldsExceptTranslatables();
            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($values[$multilangsField])) {
                    $m->setTranslation($multilangsField, $lang, $values[$multilangsField]);
                    unset($values[$multilangsField]);
                }
            }
            foreach ($fields as $field) {
                if(isset($values[$field])) {
                    $m->{$field} = $values[$field];
                }
            }
        }
        else {
            $m->fill($values);
        }

        $m->save();

        return $m;
    }
    public function delete($m) {
        $hasSub = $m->HasSublevel;
        if($hasSub) {
            $ms = new Comment();
            $sublevels = $ms->Sublevel($m->id)->get();
            foreach ($sublevels as $sublevel) {
                # code...
                if($sublevel->HasSublevel) {
                    $this->delete($sublevel);
                }
                $sublevel->delete();
                
            }
        }
        $m->delete();
    }
}
