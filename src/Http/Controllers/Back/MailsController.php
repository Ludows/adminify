<?php

namespace Ludows\Adminify\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Adminify\Http\Requests\CreateMailRequest;
use App\Adminify\Http\Requests\UpdateMailRequest;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Adminify\Http\Controllers\Controller;

use App\Adminify\Repositories\MailsRepository;

use Ludows\Adminify\Traits\TableManagerable;
use App\Adminify\Tables\MailsTable;

use App\Adminify\Forms\CreateMail;
use App\Adminify\Forms\UpdateMail;

use App\Adminify\Models\Mailables;
use Mail;


class MailsController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $mailRepository;

    public function __construct(MailsRepository $mailRepository) {

        $this->mailRepository = $mailRepository;
        $this->middleware(['permission:read|create_mails'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_mails'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|send_mails'], ['only' => ['send']]);
        $this->middleware(['permission:read|delete_mails'], ['only' => ['destroy']]);
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(Request $request)
        {
            $table = $this->table(MailsTable::class);            

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
            $form = $this->makeForm(CreateMail::class, [
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
            $form = $this->makeForm(CreateMail::class);

            $mail = $this->mailRepository->addModel(new Mailables())->create($form);

            return $this->sendResponse($mail, 'mails.index', 'admin.typed_data.success');
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

            $form = $this->makeForm(UpdateMail::class, [
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
            
            $form = $this->makeForm(UpdateMail::class, [
                'method' => 'PUT',
                'url' => route('mails.update', ['mail' => $mail->id]),
                'model' => $mail
            ]);

            $this->mailRepository->addModel($mail)->update($form, $mail);

            return $this->sendResponse($mail, 'mails.index', 'admin.typed_data.updated');
        }

        public function send(Mailables $mail, Request $request) {

            $user = user();
            $class = $mail->mailable;
            $mail_class = app($class);

            Mail::to($user->email)->send($mail_class);

            return $this->sendResponse($mail_class, 'mails.index', 'admin.typed_data.success');

            // if($request->ajax()) {
            //     return response()->json([
            //         'mail' => $mail,
            //         'message' => __('admin.typed_data.success')
            //     ]);
            // }
            // else {
            //     flash(__('admin.typed_data.success'))->success();
            //     return redirect()->route('mails.index');
            // }
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
            $this->mailRepository->addModel($mail)->delete($mail);
            // redirect
            return $this->sendResponse($mail, 'mails.index', 'admin.typed_data.deleted');

        }
}
