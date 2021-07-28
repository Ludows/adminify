<?php

namespace Ludows\Adminify\Http\Controllers\Auth;

use Ludows\Adminify\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Forms\ShowResetForm;
class ForgotPasswordController extends Controller
{
    use FormBuilderTrait;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()

    {

        $form = $this->form(ShowResetForm::class, [
            'method' => 'POST',
            'url' => route('password.email')
        ]);

        return view('adminify::auth.passwords.email', ['form' => $form]);

    }


}
