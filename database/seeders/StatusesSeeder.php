<?php
namespace Ludows\Adminify\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use App\Adminify\Models\Statuses;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $m = new Statuses();
        $tableName = $m->getTable();

        // foreach ($user_list as $key => $value) {
        //     # code...
        // }
        $statuses = $this->generateStatuses($m);
        foreach ($statuses as $status) {
            # code...
            DB::table($tableName)->insert($status);
        }
    }
    public function generateStatuses($model) {

        $a = [];
        $statuses = $model->statuses;
        $baseId = Statuses::PUBLISHED_ID;
        foreach ($statuses as $status) {
            # code...
            $a[] = [
                'id' => $baseId,
                'name' => $status
            ];
            $baseId++;
        }

        return $a;
    }
}
