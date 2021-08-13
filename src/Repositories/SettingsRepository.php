<?php

namespace Ludows\Adminify\Repositories;

use App\Models\Settings; // Don't forget to update the model's namespace
use Ludows\Adminify\Repositories\BaseRepository;

class SettingsRepository extends BaseRepository
{
    public function CreateOrUpdate($form) {

        $formValues = $form->getFieldValues(true);
        $a = [];
        
        foreach ($formValues as $key => $value) {
            $check = Settings::where('type', $key)->first();

            if($check == null) {
               $m = $this->getProcessDb($form, $this->model ?? new Settings(), ['setting:creating', 'setting:created'], 'create');
            }
            else {
                $m = $this->getProcessDb($form, $this->model ?? $check, ['setting:updating', 'setting:updated'], 'update');
            }
            $a[] = $m;
        }
        

        return $a;
    }
}
