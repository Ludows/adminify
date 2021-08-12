<?php

namespace Ludows\Adminify\Repositories;

use  Ludows\Adminify\Repositories\BaseRepository;
class TagRepository extends BaseRepository
{   
    public function delete($model) {
        $this->hookManager->run('model:deleting', $model);
        $model->delete();
        $this->hookManager->run('model:deleted', $model);
    }
}
