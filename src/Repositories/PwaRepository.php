<?php

namespace Ludows\Adminify\Repositories;

use App\Adminify\Models\Pwa; // Don't forget to update the model's namespace
use Ludows\Adminify\Repositories\BaseRepository;
use Ludows\Adminify\Libs\PwaService;
use File;

class PwaRepository extends BaseRepository
{
    public function CreateOrUpdate($form) {

        $fields = $form->getFieldValues();


        $a = [];

        foreach ($fields as $key => $value) {
            # code...
            $m = new Pwa();
            $existSetting = $m->settingExists($key);
            $ret = null;
            if(!$existSetting) {
                $ret =  $m->createSetting($key, $value);
                $a[] = $ret;
            }
            else {
                $ret = $m->updateSetting($key, $value);
                $a[] = $ret;
            }
        }

        return $a;
    }
}
