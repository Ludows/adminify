<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Don't forget to update the model's namespace
use App\Models\Media;

class UserRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Don't forget to update the model's name
        $this->model = app(User::class);
    }
    public function create($form, $request) {
        $formValues = $form->getFieldValues();
        $roles = $formValues['roles'];
        unset($formValues['roles']);

        if(isset($formValues['password'])) {
            $formValues['password'] = Hash::make($formValues['password']);
        }

        if(isset($formValues['avatar'])) {
            $json = json_decode($formValues['avatar']);
            $m = Media::where('src', $json[0]->name)->first();
            if($m != null) {
                $formValues['avatar'] = $m->id;
            }
            else {
                $formValues['avatar'] = null;
            }
        }


        $user = User::create($formValues);

        if(isset($roles)) {
            $user->assignRole($roles);
        }

        $user->save();

        return $user;
    }
    public function update($form, $request, $model) {
        $formValues = $form->getFieldValues();
        $roles = $formValues['roles'];
        unset($formValues['roles']);

        if(!Hash::check($formValues['password'], $model->password)) {
            $formValues['password'] = Hash::make($formValues['password']);
        }
        else {
            unset($formValues['password']);
        }

        if(isset($formValues['avatar'])) {
            $json = json_decode($formValues['avatar']);
            $m = Media::where('src', $json[0]->name)->first();
            if($m != null) {
                $formValues['avatar'] = $m->id;
            }
            else {
                $formValues['avatar'] = null;
            }
        }

        $model->fill($formValues);

        if(isset($roles)) {
            $model->syncRoles($roles);
        }

        $model->save();

        return $model;
    }
    public function delete($model) {

        $model->delete();
    }
}
