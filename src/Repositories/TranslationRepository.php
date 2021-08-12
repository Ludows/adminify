<?php

namespace Ludows\Adminify\Repositories;
use  Ludows\Adminify\Repositories\BaseRepository;

class TranslationRepository extends BaseRepository
{
    public $relations_columns = [];
    public function delete($model) {
        $model->delete();
    }
}
