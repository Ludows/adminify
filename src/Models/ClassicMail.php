<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Ludows\Adminify\Traits\OnBootedModel;
use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Formidable;
use Ludows\Adminify\Traits\Listable;
use Ludows\Adminify\Traits\Searchables;
use Ludows\Adminify\Traits\SavableTranslations;

use Spatie\MailTemplates\Models\MailTemplate as SpatieMailTemplate;

abstract class ClassicMail extends SpatieMailTemplate
{
    use HasFactory;
    use OnBootedModel;
    // use Urlable;
    use HasTranslations;
    use MultilangTranslatableSwitch;
    // use Sitemapable;
    use Helpers;
    use Formidable;
    use Listable;
    use Searchables;
    use SavableTranslations;
    
    public $MultilangTranslatableSwitch = ['subject', 'html_template'];
}