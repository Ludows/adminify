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


class EditorController extends Controller
{
    use FormBuilderTrait;
    use TableManagerable;
    private $mailRepository;

    public function __construct(MailsRepository $mailRepository) {

        $this->mailRepository = $mailRepository;
        $this->middleware(['permission:read|create_pages'], ['only' => ['show','create']]);
        $this->middleware(['permission:read|edit_pages'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:read|delete_pages'], ['only' => ['destroy']]);
    }
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
        public function index(Request $request)
        {
            
        }

        /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
        public function create(FormBuilder $formBuilder)
        {
            
        }

        /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
        public function store(CreateMailRequest $request)
        {
            
        }

        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return Response
            */
        public function edit(FormBuilder $formBuilder, Mailables $mail, Request $request)
        {
            
        }

        /**
            * Update the specified resource in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function update(Mailables $mail, UpdateMailRequest $request)
        {
            
            
        }

        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function destroy(Mailables $mail)
        {
            

        }
}
