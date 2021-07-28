<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicMail;
use Spatie\Feed\FeedItem;
use Spatie\Searchable\SearchResult;

class Mailable extends ClassicMail
{

    public function getTableListing() {
        return \Ludows\Adminify\Tables\MailsTable::class;
    }
}
