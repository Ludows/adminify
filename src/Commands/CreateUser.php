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
    protected $signature = 'create:user {role} {name} {email} {password}';

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

        $allowed_roles = Role::where('id', '!=', Role::GUEST)->get()->pluck('name');

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
