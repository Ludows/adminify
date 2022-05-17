<?php

namespace Ludows\Adminify\Models;

use Spatie\Permission\Models\Role as RoleBaseModel;

class Role extends RoleBaseModel
{
    const ADMINISTRATOR = 1;
    const EDITOR = 2;
    const SUBSCRIBER = 3;
    const GUEST = 4;

    public $enable_searchable = false;
    public $searchable_label = 'name';
}
