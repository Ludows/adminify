<?php

namespace Ludows\Adminify\Repositories;

use  Ludows\Adminify\Repositories\BaseRepository;
class SaveTranslationRepository extends BaseRepository
{
    public $excludes = [
        '_method',
        '_token',
        'from',
        'current_lang',
        'type',
        'id'
    ];

    public function getExcludes() {
        return $this->excludes;
    }
}
