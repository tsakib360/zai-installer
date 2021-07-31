<?php

namespace Tsakib360\ZaiInstaller\Providers;

use Illuminate\Support\ServiceProvider;

class ZaiInstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Publish config file for the installer.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__.'/../assets' => public_path('zaifiles'),
        ]);
        $this->publishes([
            __DIR__.'/../Views' => base_path('resources/views/zainiklab/installer'),
        ]);
    }
}
