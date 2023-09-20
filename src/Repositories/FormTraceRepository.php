<?php

namespace Ludows\Adminify\Repositories;

use Ludows\Adminify\Repositories\BaseRepository;

class FormTraceRepository extends BaseRepository
{
    public function beforeRun($model, $formValues, $type) {
        // if($type == 'destroy') {
        //     $entries = $model->entries;
        //     // $model->entries()->detach();
        //     foreach ($entries as $entry) {
        //         # code...
        //         $idEntry = $entry->id;
        //         $model->entries()->detach([$idEntry]);
        //         $entry->delete();
        //     }
        // }
    }
}
