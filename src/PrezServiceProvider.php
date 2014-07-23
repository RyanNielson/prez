<?php namespace RyanNielson\Prez;

use Illuminate\Support\ClassLoader;
use Illuminate\Support\ServiceProvider;
use RyanNielson\Prez\Commands\PresenterCommand;

class PrezServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('ryannielson/prez', null, __DIR__);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('prez.commands.presenter', function($app) {
            return new PresenterCommand($app['files']);
        });

        $this->commands('prez.commands.presenter');

        ClassLoader::addDirectories([
            app_path() . '/rules',
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
