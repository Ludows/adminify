<?php

namespace Ludows\Adminify\Interfacable;

use Ludows\Adminify\Libs\InterfacableManager;

class DashboardManager extends InterfacableManager {
    public function getView() {
        return 'adminify::layouts.admin.interfacable.dashboard';
    }
}
