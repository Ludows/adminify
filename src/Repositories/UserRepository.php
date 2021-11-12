<?php

namespace Ludows\Adminify\Repositories;

use App\Adminify\Models\UserPreference;
use Illuminate\Support\Facades\Hash; // Don't forget to update the model's namespace
use App\Adminify\Models\Media;

use Ludows\Adminify\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public $internal_relations_columns = [
        'avatar',
    ];
    public $external_relations_columns = [
        'roles'
    ];
    public $filters_on = [
        'password'
    ];

    public function getAvatarRelationship($model, $formValues, $type) {
        if(isset($formValues['avatar'])) {
            $model->avatar = $formValues['avatar'];
        }
    }
    public function getPasswordFilter($model, $formValues, $type) {
        $model->password = Hash::make($formValues['password']);
    }
    public function getExternalRolesRelationship($model, $formValues, $type) {
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
