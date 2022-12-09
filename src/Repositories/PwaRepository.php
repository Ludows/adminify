<?php

namespace Ludows\Adminify\Repositories;

use App\Adminify\Models\Settings; // Don't forget to update the model's namespace
use Ludows\Adminify\Repositories\BaseRepository;

class PwaRepository extends BaseRepository
{
    // public function beforeRun($a,$b, $c) {
    //     if(is_array($b['data'])) {
    //         $a->data = join(',', $b['data']);
    //     }
    // }
    // public function UntriggeredModelValue($a,$b, $c) {
    //     if(is_null($b['data'])) {
    //         $a->data = $b['data'];
    //     }
    // }
    public function CreateOrUpdate($form) {

        $fields = $form->getFieldValues();

        // $mapping_datas = [];

        // foreach ($fields as $key => $value) {
        //     # code...
        //     $mapping_datas[] = [
        //         'type' => $key,
        //         'data' => $value,
        //     ];        
        // }

        // $a = [];
        
        // foreach ($mapping_datas as $mapping_data) {
        //     $check = Settings::where('type', $mapping_data['type'])->first();

        //     if($check == null) {
        //        $m = $this->getProcessDb($mapping_data, $this->model ?? new Settings(), 'create');
        //     }
        //     else {
        //         $m = $this->getProcessDb($mapping_data, $this->model ?? $check, 'update');
        //     }
        //     $a[] = $m;
        // }
        
        // // $this->hookManager->run('process:finished', null);
        // return $a;
    }
}
