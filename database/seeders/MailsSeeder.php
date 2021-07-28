<?php
namespace Ludows\Adminify\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use App\Models\Mailable;

class MailsSeeder extends Seeder
{
    public $mails = [
        App\Mails\WelcomeMail::class
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
    }
}
