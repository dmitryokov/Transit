<?php

namespace Kenarkose\Transit\Provider;


use Illuminate\Support\ServiceProvider;
use Kenarkose\Transit\Service\DownloadService;

class TransitServiceProvider extends ServiceProvider {

    const version = '1.1.2';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Registers the service provider
     */
    public function register()
    {
        $this->registerUploadPath();

        $this->registerUploadService();
        $this->registerDownloadService();

        $this->registerCommands();
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        // This is for model and migration templates
        // we use blade engine to generate these files
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/templates', '_transit');

        $this->publishes([
            dirname(__DIR__) . '/resources/config.php' => config_path('transit.php')
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'path.upload',
            'transit.upload',
            'transit.download'
        ];
    }

    /**
     * Registers the upload path
     */
    protected function registerUploadPath()
    {
        $this->app['path.upload'] = $this->app->share(function ()
        {
            return ($configuredPath = config('transit.upload_path'))
                ? base_path($configuredPath)
                : public_path('upload');
        });
    }

    /**
     * Registers upload service
     */
    protected function registerUploadService()
    {
        $this->app->singleton(
            'transit.upload',
            'Kenarkose\Transit\Service\UploadService'
        );
    }

    /**
     * Registers download service
     */
    protected function registerDownloadService()
    {
        $this->app->singleton(
            'transit.download',
            'Kenarkose\Transit\Service\DownloadService'
        );
    }

    /**
     * Registers Transit helper commands
     */
    protected function registerCommands()
    {
        $this->commands([
           'Kenarkose\Transit\Console\CreateModelCommand',
           'Kenarkose\Transit\Console\CreateMigrationCommand'
        ]);
    }

}