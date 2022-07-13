<?php

namespace Ludows\Adminify\Interfacable;

use Ludows\Adminify\Libs\InterfacableManager;

class DashboardManager extends InterfacableManager {
    public function getView() {
        return 'adminify::layouts.admin.interfacable.dashboard';
    }

    public function blocks() {
        return [
            \App\Adminify\Interfacable\Blocks\PageCard::class,
            \App\Adminify\Interfacable\Blocks\PostCard::class,
            \App\Adminify\Interfacable\Blocks\CategoryCard::class,
            \App\Adminify\Interfacable\Blocks\TranslationsCard::class,
            \App\Adminify\Interfacable\Blocks\MediaCard::class,
            \App\Adminify\Interfacable\Blocks\TagCard::class,
            \App\Adminify\Interfacable\Blocks\MenuCard::class, 
        ];
    }
}
