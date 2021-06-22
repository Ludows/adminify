<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use Ludows\Adminify\Models\User;
use Illuminate\Support\Facades\Hash; // Don't forget to update the model's namespace

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

        if(isset($formValues['password'])) {
            $formValues['password'] = Hash::make($formValues['password']);
        }

        if(isset($formValues['avatar'])) {
            $json = json_decode($formValues['avatar']);
            $formValues['avatar'] = $json[0]->name;
        }

        $user = User::create($formValues);
        $user->save();

        return $user;
    }
    public function update($form, $request, $model) {
        $formValues = $form->getFieldValues();

        if(!Hash::check($formValues['password'], $model->password)) {
            $formValues['password'] = Hash::make($formValues['password']);
        }
        else {
            unset($formValues['password']);
        }

        if(isset($formValues['avatar'])) {
            $json = json_decode($formValues['avatar']);
            $formValues['avatar'] = $json[0]->name;
        }

        $model->fill($formValues);
        $model->save();

        return $model;
    }
    public function delete($model) {

        $model->delete();
    }
}
