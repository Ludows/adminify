<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Requests\CreateMailRequest;
use App\Http\Requests\UpdateMailRequest;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use Ludows\Adminify\Http\Controllers\Controller;

use App\Repositories\MailsRepository;

use Ludows\Adminify\Traits\TableManagerable;
use Ludows\Adminify\Tables\MailsTable;

use App\Forms\CreateMail;
use App\Forms\UpdateMail;

use App\Models\Mailables;
use Mail;


class MailsController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $mailRepository;

    public function __construct(MailsRepository $mailRepository) {

        $this->mailRepository = $mailRepository;
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(Request $request)
        {
            $table = $this->table(new MailsTable());            

            return view("adminify::layouts.admin.pages.index", ["table" => $table]);
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            //
            $form = $formBuilder->create(CreateMail::class, [
                'method' => 'POST',
                'url' => route('mails.store')
            ]);

            return view("adminify::layouts.admin.pages.create", ['form' => $form]);
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateMailRequest $request)
        {
            // we pass context and request
            $form = $this->form(CreateMail::class);

            $mail = $this->mailRepository->create($form, $request);

            if($request->ajax()) {
                return response()->json([
                    'category' => $mail,
                    'message' => __('admin.typed_data.success')
                ]);
            }
            else {
                flash(__('admin.typed_data.success'))->success();
                return redirect()->route('mails.index');
            }
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function edit(FormBuilder $formBuilder, Mailables $mail, Request $request)
        {
            //
            $mail->checkForTraduction();
            // $category->flashForMissing();

            $form = $formBuilder->create(UpdateMail::class, [
                'method' => 'PUT',
                'url' => route('mails.update', ['mail' => $mail->id]),
                'model' => $mail
            ]);

            return view("adminify::layouts.admin.pages.edit", ['form' => $form]);
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Mailables $mail, UpdateMailRequest $request)
        {
            
            $form = $this->form(UpdateMail::class, [
                'method' => 'PUT',
                'url' => route('mails.update', ['mail' => $mail->id]),
                'model' => $mail
            ]);

            $this->mailRepository->update($form, $request, $mail);
            flash(__('admin.typed_data.updated'))->success();
            return redirect()->route('mails.index');
        }

        public function send(Mailables $mail, Request $request) {

            $user = user();
            $class = $mail->mailable;
            $mail_class = app($class);

            Mail::to($user->email)->send($mail_class);

            if($request->ajax()) {
                return response()->json([
                    'mail' => $mail,
                    'message' => __('admin.typed_data.success')
                ]);
            }
            else {
                flash(__('admin.typed_data.success'))->success();
                return redirect()->route('mails.index');
            }
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(Mailables $mail)
        {
            //
            $this->mailRepository->delete($category);

            // redirect
            flash(__('admin.typed_data.deleted'))->success();
            return redirect()->route('mails.index');
        }
}
