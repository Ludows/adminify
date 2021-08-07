<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;

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
        
        return 0;
    }
}
