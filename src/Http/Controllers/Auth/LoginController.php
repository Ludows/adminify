<?php

namespace Ludows\Adminify\Http\Controllers\Auth;

use Ludows\Adminify\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\ShowLoginForm;

class LoginController extends Controller
{
    use FormBuilderTrait;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()

    {
        $form = $this->makeForm(ShowLoginForm::class, [
            'method' => 'POST',
            'url' => route('auth.login')
        ]);

        $views = $this->getPossiblesViews('Login');
        // view('adminify::auth.login', ['form' => $form])
        
        return $this->renderView($views, [
            'model' => (object) [],
            'form' => $form->toArray()
        ]);

    }
}
