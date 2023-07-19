<?php

namespace Ludows\Adminify\Http\Controllers\Auth;

use Ludows\Adminify\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Forms\ShowResetForm;
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

        $form = $this->makeForm(ShowResetForm::class, [
            'method' => 'POST',
            'url' => route('auth.password.email')
        ]);

        $views = $this->getPossiblesViews('ForgotPassword');
        // view('adminify::auth.login', ['form' => $form])
        
        return $this->renderView($views, [
            'model' => (object) [],
            'form' => $form->toArray()
        ]);
    }


}
