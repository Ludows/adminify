<?php

namespace Ludows\Adminify\Repositories;

use App\Models\UserPreference;
use Illuminate\Support\Facades\Hash; // Don't forget to update the model's namespace
use App\Models\Media;

use Ludows\Adminify\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public $relations_columns = [
        'avatar',
        'roles'
    ];
    public $filters_on = [
        'password'
    ];

    public function getAvatarRelationship($model, $formValues, $type) {
        if(isset($formValues['avatar'])) {
            $json = json_decode($formValues['avatar']);
            $m = Media::where('src', $json[0]->name)->first();
            if($m != null) {
                $model->avatar = $m->id;
            }
            else {
                $model->avatar = null;
            }
        }
    }
    public function getPasswordFilter($model, $formValues, $type) {
        $model->password = Hash::make($formValues['password']);
    }
    public function getRolesRelationship($model, $formValues, $type) {
        if(isset($formValues['roles']) && $type == "create") {
            $model->assignRole($formValues['roles']);
        }

        if(isset($formValues['roles']) && $type == "update") {
            $model->syncRoles($formValues['roles']);
        }
    }
    public function saveProfile($values) {

        $userId = $values['user_id'] ?? user()->id;
        if(isset($values['user_id'])) {
            unset($values['user_id']);
        }

        if(!isset($values['topbar'])) {
            $values['topbar'] = 0;
        }

        foreach ($values as $key => $value) {
            # code...
            $pref = new UserPreference();

            $check = $pref->type($key)->userId($userId)->get()->first();

            if($check != null) {
                $pref = $check;
            }

            $pref->type = $key;
            $pref->data = $value;
            $pref->user_id = $userId;

            if($check != null) {
                $this->hookManager->run('updating:profile', $pref);
            }
            else {
                $this->hookManager->run('saving:profile', $pref);
            }

            $pref->save();

            if($check != null) {
                $this->hookManager->run('update:profile', $pref);
            }
            else {
                $this->hookManager->run('save:profile', $pref);
            }
        }

    }
}
