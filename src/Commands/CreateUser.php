<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:user {roles} {name} {email} {password}';

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

    public function formatArgument(string $argument, string $strToMatch = '', string $strClear = '') {
        return str_replace($strToMatch, $strClear, $argument);
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
        $trigger_error = false;

        $allowed_roles = Role::where('id', '!=', Role::GUEST)->get()->pluck('name')->all();

        //dd($arguments);

        $roles_str = $this->formatArgument($arguments['roles'], 'roles=', '');
        $roles_str = $this->formatArgument($roles_str, '"', '');

        if(str_contains($roles_str, ',')) {
            //breakable roles
            $roles = explode(',' ,$roles_str);
        }
        else {
            $roles[] = $roles_str;
        }

        foreach ($roles as $r) {
            # code...
            $asignable_role = trim(strtolower($r));
            if(!in_array( $asignable_role,  $allowed_roles)) {
                $this->info('Skipping '.$r.' because no exist in db. You MUST provide valids roles.');
                $trigger_error = true;
                break;
            }
        }

        if($trigger_error) {
            return false;
        }

        $u = new User();

        $u->name = $this->formatArgument($arguments['name'], 'name=', '');
        $u->email = $this->formatArgument($arguments['email'], 'email=', '');
        $u->password = Hash::make( $this->formatArgument($arguments['password'], 'password=', '') );

        $u->save();
        // we got a new user let's go to map roles
    
        
            foreach ($roles as $r) {
                # code...
                $asignable_role = trim(strtolower($r));
                if(in_array( $asignable_role,  $allowed_roles)) {
                    $u->assignRole($asignable_role);
                }
            }

        // $roles_writtent_by_user = $this->formatArgument($arguments['roles'])

        

        
        
    }
}
