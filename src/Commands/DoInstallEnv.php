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

    public function setEnvironmentValue(array $values)
    {

        if (!empty($values) > 0) {
            foreach ($values as $envKey => $envValue) {


                $this->call('env:set', [
                    'key' => $envKey,
                    'value' => $envValue
                ]);
            }

        }

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $keys = [];

        $app_multilang = $this->choice(
            __('adminify.questions.multilang'),
            [__('adminify.questions.yes'), __('adminify.questions.no')],
            1,
            null,
            false
        );

        $keys['ENABLE_MULTILANG'] = !empty($app_multilang) ? $app_multilang : 0;

        $app_url = $this->ask(__('adminify.questions.app_url'));

        $keys['APP_URL'] = !empty($app_url) ? $app_url : '';

        $app_name = $this->ask(__('adminify.questions.app_name'));

        $keys['APP_NAME'] = !empty($app_name) ? $app_name : '';

        $user_db = $this->ask(__('adminify.questions.user_db'));

        $keys['DB_USERNAME'] = !empty($user_db) ? $user_db : '';

        $password_db = $this->ask(__('adminify.questions.password_db'));

        $keys['DB_PASSWORD'] = !empty($password_db) ? $password_db : '';

        $db_name = $this->ask(__('adminify.questions.db_name'));

        $keys['DB_DATABASE'] = !empty($db_name) ? $db_name : '';

        $keys['MIX_ADMINIFY_THEME_ROOT_FOLDER'] = "resources/theme";

        $keys['GLIDE_SECURE_KEY'] = exec('openssl rand -base64 32');

        // dd($keys);

        $this->setEnvironmentValue($keys);

        return 0;
    }
}
