<?php

namespace Ludows\Adminify\Repositories;

use Ludows\Adminify\Repositories\BaseRepository;

class GroupMetasRepository extends BaseRepository
{
    public function afterRun($model, $formValues,  $type) {

            // dd('$formValues', $formValues);

    //     //retrieve the form model from request
    //     $f = request()->model;

    //     // prevent dupplicated ids in db
    //     if($type == "update") {
    //        $f->confirmation()->detatch();
    //     }

    //    // prepare to insert the relationship
    //    $f->confirmation()->attach([$model->id]);

  }
}
