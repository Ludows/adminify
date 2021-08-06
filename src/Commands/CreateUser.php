<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\Role;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user
            {role?* : Roles are Administrator, Editor, Subscriber,
            name : set the full name of the user,
            email : set the email of the user,
            password : set the password of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create User with role';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $roles = array();
        $arguments = $this->arguments();

        dd($arguments);

        if(isset($arguments['role'])) {
            foreach ($arguments['role'] as $t) {
                # code...
                $roles[] = str_replace('role=', '', $t);
            }
        }

        $u = new User();

        
        
    }
}
