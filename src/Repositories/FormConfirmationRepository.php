<?php

namespace Ludows\Adminify\Repositories;

use Ludows\Adminify\Repositories\BaseRepository;

class FormConfirmationRepository extends BaseRepository
{
   public function afterRun($model, $formValues,  $type) {

        //retrieve the form model from request
        $f = request()->model;

        // prepare to insert the relationship
        $f->confirmation()->attach([$model->id]);

   }
}
