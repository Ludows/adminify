<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DoInstallEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for install user , password and db name for adminify';

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

        $app_url = $this->ask(__('adminify.questions.app_url'));
        
        Artisan::call('env:set APP_URL '.$app_url);

        $app_name = $this->ask(__('adminify.questions.app_name'));
        
        Artisan::call('env:set APP_NAME '.$app_name);

        $user_db = $this->ask(__('adminify.questions.user_db'));
        
        Artisan::call('env:set DB_USERNAME '.$user_db);

        $password_db = $this->ask(__('adminify.questions.password_db'));

        Artisan::call('env:set DB_PASSWORD '.$password_db);

        $db_name = $this->ask(__('adminify.questions.db_name'));

        Artisan::call('env:set DB_DATABASE '.$db_name);

        return 0;
    }
}
