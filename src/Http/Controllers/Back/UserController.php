<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use App\Adminify\Models\User;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Http\Requests\CreateUserRequest;
use App\Adminify\Http\Requests\UserUpdateRequest;
use Ludows\Adminify\Http\Controllers\Controller;

use App\Adminify\Forms\CreateUser;
use App\Adminify\Forms\UpdateUser;
use App\Adminify\Forms\ShowProfile;

use App\Adminify\Repositories\UserRepository;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\UserTable;

class UserController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;

    private $userRepository;

    public function __construct(UserRepository $userRepository) {

        $this->userRepository = $userRepository;
        
        $this->middleware(['permission:read|create_users'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_users'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|update_profile'], ['only' => ['showProfile', 'saveProfile']]);
        $this->middleware(['permission:read|delete_users'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model, FormBuilder $formBuilder)
    {

            $table = $this->table(UserTable::class);
            

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
                    'status' => __('admin.typed_data.success')
                ]);
            }
            else {
                flash(__('admin.typed_data.success'))->success();
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
                        'status' => __('admin.typed_data.updated')
                    ]);
                }
                else {
                    flash(__('admin.typed_data.updated'))->success();
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
                flash(__('admin.typed_data.deleted'))->success();
                return redirect()->route('users.index');
            }
            public function showProfile(User $user, FormBuilder $formBuilder) {
                
                $form = $formBuilder->create(ShowProfile::class, [
                    'method' => 'POST',
                    'url' => route('users.profile.store', ['user' => $user->id]),
                    'model' => $user
                ]);

                return view("adminify::layouts.admin.pages.profile", ['form' => $form]);
            }
            public function saveProfile(User $user, FormBuilder $formBuilder) {

                $form = $this->form(ShowProfile::class, [
                    'model' => $user
                ]);
                $formValues = $form->getFieldValues();

                $this->userRepository->saveProfile($formValues);
                flash(__('admin.typed_data.updated'))->success();
                return redirect()->route('users.index');
            }
}
