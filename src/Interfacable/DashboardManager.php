<?php

namespace Ludows\Adminify\Interfacable;

use Ludows\Adminify\Libs\InterfacableManager;

class DashboardManager extends InterfacableManager {
    public function getView() {
        return 'adminify::layouts.admin.interfacable.dashboard';
    }

    public function blocks() {
        return [
            \Ludows\Adminify\Interfacable\Blocks\PageCard::class,
            \Ludows\Adminify\Interfacable\Blocks\PostCard::class,
            \Ludows\Adminify\Interfacable\Blocks\CategoryCard::class,
            \Ludows\Adminify\Interfacable\Blocks\TranslationsCard::class,
            \Ludows\Adminify\Interfacable\Blocks\MediaCard::class,
            \Ludows\Adminify\Interfacable\Blocks\TagCard::class,
            \Ludows\Adminify\Interfacable\Blocks\MailCard::class,
            \Ludows\Adminify\Interfacable\Blocks\MenuCard::class, 
        ];
    }
}
