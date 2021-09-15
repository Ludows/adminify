<?php

namespace Ludows\Adminify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Translatable\HasTranslations;
use Ludows\Adminify\Traits\MultilangTranslatableSwitch;
use Ludows\Adminify\Traits\Helpers;
use Ludows\Adminify\Traits\Formidable;
use Ludows\Adminify\Traits\Listable;
use Ludows\Adminify\Traits\Searchables;
use Ludows\Adminify\Traits\SavableTranslations;
use Ludows\Adminify\Traits\AdminableMenu;

use Spatie\MailTemplates\Models\MailTemplate as SpatieMailTemplate;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

abstract class ClassicMail extends SpatieMailTemplate implements Searchable
{
    use HasFactory;
    use AdminableMenu;
    // use Urlable;
    use HasTranslations;
    use MultilangTranslatableSwitch;
    // use Sitemapable;
    use Helpers;
    use Formidable;
    use Listable;
    use Searchables;
    use SavableTranslations;

    protected $table = 'mail_templates';

    protected $fillable = [
        'mailable', //the path you uploaded the image
        'subject',
        'html_template',
        'text_template',
    ];

    public function getSearchResult() : SearchResult
    {
       $url = route('mailables.edit', ['mailable' => $this->id]);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->{$this->searchable_label},
           $url
        );
    }

    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [
        'subject' => NULL,
        'text_template' => NULL,
     ];

    public function getTableListing() {
        return \Ludows\Adminify\Tables\MailsTable::class;
    }

    public function getSavableForm() {
        return null;
    }
    
    public $MultilangTranslatableSwitch = ['subject', 'html_template'];
}