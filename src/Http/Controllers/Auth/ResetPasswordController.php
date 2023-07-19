<?php

namespace Ludows\Adminify\Http\Controllers\Auth;

use Ludows\Adminify\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\ShowResetForm;

class ResetPasswordController extends Controller
{
    use FormBuilderTrait;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request)

    {

        $form = $this->makeForm(ShowResetForm::class, [
            'method' => 'POST',
            'url' => route('auth.password.update')
        ]);

        $views = $this->getPossiblesViews('PasswordResets');
        // view('adminify::auth.login', ['form' => $form])
        
        return $this->renderView($views, [
            'model' => (object) [],
            'form' => $form->toArray()
        ]);
    }

}
