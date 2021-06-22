<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Ludows\Adminify\Models\User;
use Ludows\Adminify\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use Ludows\Adminify\Http\Requests\CreateUserRequest;
use Ludows\Adminify\Http\Requests\UserUpdateRequest;
use Ludows\Adminify\Http\Controllers\Controller;

use Ludows\Adminify\Actions\Users as UserAction;
use Ludows\Adminify\Forms\CreateUser;
use Ludows\Adminify\Forms\UpdateUser;
use Ludows\Adminify\Repositories\UserRepository;
class UserController extends Controller
{
    use FormBuilderTrait;
    private $userRepository;

    public function __construct(UserRepository $userRepository) {

        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model, FormBuilder $formBuilder)
    {
            $users = User::all();
            $fillables = $model->getFillable();

            // no necessary to print password..

            $actions = array();

            foreach ($users as $user) {
                # code...

                $actions[] = new UserAction($user, [
                    'form' => $formBuilder->create(\App\Forms\DeleteCrud::class, [
                        'method' => 'DELETE',
                        'url' => route('users.destroy', ['user' => $user->id])
                    ])
                ]);
            }

            return view("layouts.admin.pages.index", ["datas" => $users,  'thead' => $fillables, 'actions' => $actions]);
    }
    /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
            public function create(FormBuilder $formBuilder)
            {
                //
                $form = $formBuilder->create(\App\Forms\CreateUser::class, [
                    'method' => 'POST',
                    'url' => route('users.store')
                ]);

                return view("layouts.admin.pages.create", ['form' => $form]);
            }

            /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateUserRequest $request)
        {
            //
            $form = $this->form(CreateUser::class);
            $user = $this->userRepository->create($form, $request);
            if($request->ajax()) {
                return response()->json([
                    'user' => $user,
                    'status' => 'L\'utilisateur a bien été crée !'
                ]);
            }
            else {
                flash('L\'utilisateur a bien été crée !')->success();
                return redirect()->route('users.index');
            }
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
            public function edit(User $user, FormBuilder $formBuilder)
            {
                //
                $form = $formBuilder->create(\App\Forms\UpdateUser::class, [
                    'method' => 'PUT',
                    'url' => route('users.update', ['user' => $user->id]),
                    'model' => $user
                ]);

                return view("layouts.admin.pages.edit", ['form' => $form]);
            }
        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
            public function update(User $user, UserUpdateRequest $request)
            {
                //
                $form = $this->form(UpdateUser::class, [
                    'method' => 'PUT',
                    'url' => route('users.update', ['user' => $user->id]),
                    'model' => $user
                ]);

                $this->userRepository->update($form, $request, $user);

                if($request->ajax()) {
                    return response()->json([
                        'user' => $user,
                        'status' => 'L\'utilisateur a bien été mis à jour !'
                    ]);
                }
                else {
                    flash('L\'utilisateur a bien été mis à jour !')->success();
                    return redirect()->route('users.index');
                }
            }
            /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
            public function destroy(User $user)
            {
                //
                //
                $this->userRepository->delete($user);

                // redirect
                flash('L\'utilisateur a bien été supprimé !')->success();
                return redirect()->route('users.index');
            }
}
