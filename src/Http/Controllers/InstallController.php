<?php

namespace Tsakib360\ZaiInstaller\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Tsakib360\ZaiInstaller\Events\EnvironmentSaved;
use Tsakib360\ZaiInstaller\Http\Helpers\DatabaseManager;

class InstallController extends Controller
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {

        $this->databaseManager = $databaseManager;
    }

    public function preInstall()
    {
        $route_value = 0;
        $resource_value = 0;
        $public_value = 0;
        $storage_value = 0;
        $env_value = 0;
        $route_perm = substr(sprintf('%o', fileperms(base_path('routes'))), -4);
        if($route_perm == '0777') {
            $route_value = 1;
        }
        $resource_prem = substr(sprintf('%o', fileperms(base_path('resources'))), -4);
        if($resource_prem == '0777') {
            $resource_value = 1;
        }
        $public_prem = substr(sprintf('%o', fileperms(base_path('public'))), -4);
        if($public_prem == '0777') {
            $public_value = 1;
        }
        $storage_prem = substr(sprintf('%o', fileperms(base_path('storage'))), -4);
        if($storage_prem == '0777') {
            $storage_value = 1;
        }
        $env_prem = substr(sprintf('%o', fileperms(base_path('.env'))), -4);
        if($env_prem == '0777' || $env_prem == '0666') {
            $env_value = 1;
        }
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }
        return view('zainiklab.installer.pre-install', compact('route_value', 'resource_value', 'public_value', 'storage_value', 'env_value'));
    }

    public function configuration()
    {
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }
        if(session()->has('validated')) {
            return view('zainiklab.installer.config');
        }
        return redirect(route('ZaiInstaller::pre-install'));
    }

    public function serverValidation(Request $request)
    {
        if($this->phpversion() > 7.0 && $this->mysqli() == 1 && $this->curl_version() == 1 && $this->allow_url_fopen() == 1 && $this->openssl() == 1 && $this->pdo() == 1 && $this->bcmath() == 1 && $this->ctype() == 1 && $this->fileinfo() == 1 && $this->mbstring() == 1 && $this->tokenizer() == 1 && $this->xml() == 1 && $this->json() == 1 && $request->routes == 1 && $request->resources == 1 && $request->public == 1 && $request->storage = 1 && $request->env == 1){
            session()->put('validated', 'Yes');
            return redirect(route('ZaiInstaller::config'));
        }
        session()->forget('validated');
        return redirect(route('ZaiInstaller::pre-install'));
    }

    public function phpversion()
    {
        return phpversion();
    }

    public function mysqli()
    {
        return extension_loaded('mysqli');
    }

    public function curl_version()
    {
        return function_exists('curl_version');
    }

    public function allow_url_fopen()
    {
        return ini_get('allow_url_fopen');
    }

    public function openssl()
    {
        return extension_loaded('openssl');
    }

    public function pdo()
    {
        return extension_loaded('pdo');
    }

    public function bcmath()
    {
        return extension_loaded('bcmath');
    }

    public function ctype()
    {
        return extension_loaded('ctype');
    }

    public function fileinfo()
    {
        return extension_loaded('fileinfo');
    }

    public function mbstring()
    {
        return extension_loaded('mbstring');
    }

    public function tokenizer()
    {
        return extension_loaded('tokenizer');
    }

    public function xml()
    {
        return extension_loaded('xml');
    }

    public function json()
    {
        return extension_loaded('json');
    }

    public function final(Request $request)
    {
        if($request->purchasecode != 'NHLE-L6MI-4GE4-ETEV') {
            return Redirect::back()->withErrors('Purchase code not matched!');
        }

        if (! $this->checkDatabaseConnection($request)) {
            return Redirect::back()->withErrors('Database credential is not correct!');
        }
        $results = $this->saveENV($request);

        event(new EnvironmentSaved($request));

        return Redirect::route('ZaiInstaller::database')
                        ->with(['results' => $results]);


    }

    public function database()
    {
        $response = $this->databaseManager->migrateAndSeed();

        if($response['status'] = 'success') {
            $installedLogFile = storage_path('installed');

            $dateStamp = date('Y/m/d h:i:sa');

            if (! file_exists($installedLogFile)) {
                $message = trans('ZaiInstaller successfully INSTALLED on ').$dateStamp."\n";

                file_put_contents($installedLogFile, $message);
            }
            return redirect('/');
        }
        else {
            return Redirect::back()->withErrors($response['message']);
        }
    }

    public function saveENV(Request $request)
    {
        $envPath = base_path('.env');

        $envFileData =
        'APP_NAME=\''.$request->app_name."'\n".
        'APP_ENV=local'."\n".
        'APP_KEY='.'base64:'.base64_encode(Str::random(32))."\n".
        'APP_DEBUG=true'."\n".
        'APP_URL='.$request->app_url."\n\n".
        'LOG_CHANNELL=stack'."\n".
        'LOG_LEVEL=debug'."\n\n".
        'DB_CONNECTION=mysql'."\n".
        'DB_HOST='.$request->db_host."\n".
        'DB_PORT=3306'."\n".
        'DB_DATABASE='.$request->db_name."\n".
        'DB_USERNAME='.$request->db_user."\n".
        'DB_PASSWORD='.$request->db_password."\n\n".
        'BROADCAST_DRIVER=log'."\n".
        'CACHE_DRIVER=file'."\n".
        'FILESYSTEM_DRIVER=local'."\n".
        'QUEUE_CONNECTION=sync'."\n".
        'SESSION_DRIVER=file'."\n".
        'SESSION_LIFETIME=120'."\n\n".
        'MEMCACHED_HOST=127.0.0.1'."\n\n".
        'REDIS_HOST=127.0.0.1'."\n".
        'REDIS_PASSWORD=null'."\n".
        'REDIS_PORT=6379'."\n\n".
        'MAIL_MAILER=smtp'."\n".
        'MAIL_HOST='.$request->mail_host."\n".
        'MAIL_PORT='.$request->mail_port."\n".
        'MAIL_USERNAME='.$request->mail_username."\n".
        'MAIL_PASSWORD='.$request->mail_password."\n".
        'MAIL_ENCRYPTION=null'."\n".
        'MAIL_FROM_ADDRESS=null'."\n".
        'MAIL_FROM_NAME=\''.$request->app_name."'\n\n".
        'AWS_ACCESS_KEY_ID='."\n".
        'AWS_SECRET_ACCESS_KEY='."\n".
        'AWS_DEFAULT_REGION=us-east-1'."\n".
        'AWS_BUCKET='."\n".
        'AWS_USE_PATH_STYLE_ENDPOINT=false'."\n\n".
        'PUSHER_APP_ID='."\n".
        'PUSHER_APP_KEY='."\n".
        'PUSHER_APP_SECRET='."\n".
        'PUSHER_APP_CLUSTER=mt1'."\n\n".
        'MIX_PUSHER_APP_KEY='."\n".
        'MIX_PUSHER_APP_CLUSTER='."\n\n".
        'PAYPAL_BASE_URI=https://api-m.sandbox.paypal.com'."\n".
        'PAYPAL_CLIENT_ID=ASKGuXrMkRNWHnhAb4A49DzDH5WV4KI1tzwvHw1uaLJPHHSY27jc1AyjjdXFni_fVEcuS9FI1EKZcdNm'."\n".
        'PAYPAL_CLIENT_SECRET=EFZXxyknLyWXu-ggniZSGwAwqFdH5Y3vS6nEcSD77c8mEvI6NPuDVQt-WpIcz2kTXsLukY32TZ8slIZa'."\n".
        'PAYPAL_MONTHLY_PLAN=P-3HL46566ET627512XMDBS6EI'."\n".
        'PAYPAL_YEARLY_PLAN=P-57E26743EH969593FMDBS7QI'."\n\n".
        'STRIPE_BASE_URI=https://api.stripe.com'."\n".
        'STRIPE_KEY=pk_test_51IkVYcHdZxBbG9oi0vltSm75Gd1Sb7MSD0MGGQzz2u2c1Zma6WCxxqi0gTXAM7xgmdZZIVeB1cXkgmYAmRpusWPg003YEtwhB3'."\n".
        'STRIPE_SECRET=sk_test_51IkVYcHdZxBbG9oitCh17bmvc6kHhOtQ8HkanugbLwRlre52F6uq0Vs4cec7hHEwY2FeRmFSMmIMDtjGA0O9eVlM00ziij2UgJ'."\n\n".
        'SSLCOMMERZE_BASE_URI= https://sandbox.sslcommerz.com'."\n\n".
        'GOOGLE_CLIENT_ID=156170740263-a6fo43vhbh0uc4ehf56hm4e948u301kn.apps.googleusercontent.com'."\n".
        'GOOGLE_CLIENT_SECRET=ihbqeruodUfTOxMwJXHvnZn3'."\n\n".
        'FACEBOOK_CLIENT_ID=241753833950328'."\n".
        'FACEBOOK_CLIENT_SECRET=aaad2a133ceb80661b5545abab8e5bde';

        file_put_contents($envPath, $envFileData);

    }

    private function checkDatabaseConnection(Request $request)
    {
        $connection = 'mysql';

        $settings = config("database.connections.mysql");

        config([
            'database' => [
                'default' => 'mysql',
                'connections' => [
                    'mysql' => array_merge($settings, [
                        'driver' => 'mysql',
                        'host' => $request->db_host,
                        'port' => '3306',
                        'database' => $request->db_name,
                        'username' => $request->db_user,
                        'password' => $request->db_password,
                    ]),
                ],
            ],
        ]);

        DB::purge();

        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }




}
