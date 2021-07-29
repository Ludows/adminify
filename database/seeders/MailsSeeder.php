<?php
namespace Ludows\Adminify\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;


use App\Models\Mailable;

class MailsSeeder extends Seeder
{
    public $mails = [
        \App\Mails\WelcomeMail::class
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $m = new Statuses();
        // $tableName = $m->getTable();

        // // foreach ($user_list as $key => $value) {
        // //     # code...
        // // }
        // $statuses = $this->generateStatuses($m);
        // foreach ($statuses as $status) {
        //     # code...
        //     DB::table($tableName)->insert($status);
        // }
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
