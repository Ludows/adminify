<?php

namespace Ludows\Adminify\Repositories;

use App\Models\Settings; // Don't forget to update the model's namespace
use Ludows\Adminify\Repositories\BaseRepository;

class SettingsRepository extends BaseRepository
{
    public function CreateOrUpdate($form) {

        $fields = $form->getFieldValues();

        $mapping_datas = [];

        foreach ($fields as $key => $value) {
            # code...
            $mapping_datas[] = [
                'type' => $key,
                'data' => $value,
            ];        
        }

        $a = [];
        
        foreach ($mapping_datas as $mapping_data) {
            $check = Settings::where('type', $mapping_data['type'])->first();

            if($check == null) {
               $m = $this->getProcessDb($mapping_data, $this->model ?? new Settings(), ['setting:creating', 'setting:created'], 'create');
            }
            else {
                $m = $this->getProcessDb($mapping_data, $this->model ?? $check, ['setting:updating', 'setting:updated'], 'update');
            }
            $a[] = $m;
        }
        
        $this->hookManager->run('process:finished', null);
        return $a;
    }
}
