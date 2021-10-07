<?php

namespace Ludows\Adminify\Interfacable;

use Ludows\Adminify\Libs\InterfacableManager;

class FormBuilderManager extends InterfacableManager {
    public function getView() {
        return 'adminify::layouts.admin.interfacable.formbuilder';
    }

    public function blocks() {
        return [
        //     \App\Adminify\Interfacable\Blocks\PageCard::class,
        //     \App\Adminify\Interfacable\Blocks\PostCard::class,
        //     \App\Adminify\Interfacable\Blocks\CategoryCard::class,
        //     \App\Adminify\Interfacable\Blocks\TranslationsCard::class,
        //     \App\Adminify\Interfacable\Blocks\MediaCard::class,
        //     \App\Adminify\Interfacable\Blocks\TagCard::class,
        //     \App\Adminify\Interfacable\Blocks\MailCard::class,
        //     \App\Adminify\Interfacable\Blocks\MenuCard::class, 
        ];
    }
}
