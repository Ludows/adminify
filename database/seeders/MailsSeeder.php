<?php
namespace Ludows\Adminify\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class MailsSeeder extends Seeder
{
    public $mails = [];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->mails = adminify_get_classes_by_folders(['app:mails', 'app:adminify:mails']);
        
        $base_i = 1;
        $multilang = config('site-settings.multilang');
        $locale = App::currentLocale();

        foreach ($this->mails as $mailableClass) {
            # code...
            $subject = $multilang ? json_encode([
                $locale => $mailableClass::getSubject()
            ]) : $mailableClass::getSubject();

            $html_template = $multilang ? json_encode([
                $locale => $mailableClass::getHtmlTemplate()
            ]) : $mailableClass::getHtmlTemplate();

            DB::table('mail_templates')->insert([
                'mailable' => $mailableClass,
                'subject' => $subject,
                'html_template' => $html_template,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $base_i++;
        }
    }
}
