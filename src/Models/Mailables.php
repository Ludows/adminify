<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicMail;
use Spatie\Menu\Laravel\Link;
class Mailables extends ClassicMail
{

    public function getTableListing() {
        return \Ludows\Adminify\Tables\MailsTable::class;
    }

    public function getLinks($menuBuilder, $arrayDatas) {
        if($arrayDatas['user']->hasPermissionTo('manage_mails')) {
            $menuBuilder->add( Link::to( $arrayDatas['multilang'] ? '/admin/mails?lang='. $arrayDatas['lang'] : '/admin/mails', '<i class="ni ni-single-copy-04"></i> '.__('admin.mails.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
            // $menuBuilder->add( Link::to( $multilang ? '/admin/tags?lang='.$lang : '/admin/tags', '<i class="ni ni-single-copy-04"></i> '.__('admin.tags.index'))->setParentAttribute('class', 'nav-item')->addClass('nav-link') );
        }
    }
    
}
