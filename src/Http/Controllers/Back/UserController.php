<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserUpdateRequest;
use Ludows\Adminify\Http\Controllers\Controller;

use App\Forms\CreateUser;
use App\Forms\UpdateUser;
use App\Repositories\UserRepository;
use App\Forms\DeleteCrud;

use Ludows\Adminify\Traits\TableManagerable;
use Ludows\Adminify\Tables\User as UserTable;

class UserController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;

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

            $table = $this->table(new UserTable());
            

            return view("adminify::layouts.admin.pages.index", ['table' => $table]);
    }
    /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
            public function create(FormBuilder $formBuilder)
            {
                //
                $form = $formBuilder->create(CreateUser::class, [
                    'method' => 'POST',
                    'url' => route('users.store')
                ]);

                return view("adminify::layouts.admin.pages.create", ['form' => $form]);
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
                $form = $formBuilder->create(UpdateUser::class, [
                    'method' => 'PUT',
                    'url' => route('users.update', ['user' => $user->id]),
                    'model' => $user
                ]);

                return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
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
