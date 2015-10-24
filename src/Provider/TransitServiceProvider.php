<?php

namespace Kenarkose\Transit\Provider;


use Illuminate\Support\ServiceProvider;

class TransitServiceProvider extends ServiceProvider {

    const version = '1.3.3';

    /**
     * Registers the service provider
     */
    public function register()
    {
        $this->registerUploadPath();
        $this->registerAssetPath();

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
     * Registers the upload path
     */
    protected function registerUploadPath()
    {
        $this->app['path.upload'] = $this->app->share(function ()
        {
            return ($configuredPath = config('transit.upload_path'))
                ? public_path($configuredPath)
                : public_path('upload');
        });
    }

    /**
     * Registers the asset path
     */
    protected function registerAssetPath()
    {
        $this->app['path.uploaded_asset'] = $this->app->share(function ()
        {
            return ($configuredPath = config('transit.upload_path'))
                ? $configuredPath
                : '/upload';
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