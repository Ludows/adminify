<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class CreateUser extends Form
{
    public function buildForm()
    {
        // Add fields here...

        $rDatas = $this->getRoles();

        $this
            ->add('name', Field::TEXT, [
                'label' => __('admin.form.name'),
            ])
            ->add('avatar', 'lfm', [
                'label' => __('admin.form.avatar'),
            ])
            ->add('email', Field::EMAIL, [
                'label' => __('admin.form.email'),
            ])
            ->add('roles', 'select2', [
                'empty_value' => '',
                'choices' => $rDatas['roles'],
                'selected' => $rDatas['selected'],
                'attr' => [],
                'label' => __('admin.form.select_role'),
                'label_attr' => ['class' => 'control-label', 'for' => 'roles'],
                'select2options' => [
                    'placeholder' => __('admin.select_role'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ])
            ->add('password', 'generatorPassword', [
                'label' => __('admin.form.password'),
            ]);

        $this->add('submit', 'submit', ['label' => __('admin.create'), 'attr' => ['class' => 'btn btn-default']]);

    }
    public function getRoles() {

        $request = request();
        $roleModel = app('Spatie\Permission\Models\Role');
        $userModel = app('App\Models\User');

        $userId = $request->user ?? null;
        $user = $userModel->find($userId);

        $roleUser = null;
        if($user != null) {
            $roleUser = $user->roles->first();
        }
        
        $roles = $roleModel::get()->pluck('name' ,'id');
        $selected = [];

        if(isset($roleUser) && $roleUser != null) {
            // on a une selection
            $selected = $roleUser->id;

            // $selecteds = $selecteds->all();
        }

        return [ 'roles' => $roles, 'selected' => $selected];
    }
}
