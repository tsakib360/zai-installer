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
        if($this->phpversion() > 7.0 && $this->mysqli() == 1 && $this->curl_version() == 1 && $this->allow_url_fopen() == 1 && $this->openssl() == 1 && $this->pdo() == 1 && $this->bcmath() == 1 && $this->ctype() == 1 && $this->fileinfo() == 1 && $this->mbstring() == 1 && $this->tokenizer() == 1 && $this->xml() == 1 && $this->json() == 1){
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
        $env_val['APP_KEY'] = 'base64:'.base64_encode(Str::random(32));
        $env_val['APP_URL'] = $request->app_url;
        $env_val['DB_HOST'] = $request->db_host;
        $env_val['DB_DATABASE'] = $request->db_name;
        $env_val['DB_USERNAME'] = $request->db_user;
        $env_val['DB_PASSWORD'] = $request->db_password;
        $env_val['MAIL_HOST'] = $request->mail_host;
        $env_val['MAIL_PORT'] = $request->mail_port;
        $env_val['MAIL_USERNAME'] = $request->mail_username;
        $env_val['MAIL_PASSWORD'] = $request->mail_password;

        $this->setEnvValue($env_val);

    }

    public function setEnvValue($values) 
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $str .= "\n";
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;
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
