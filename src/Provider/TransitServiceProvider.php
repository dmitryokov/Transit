<?php

namespace Kenarkose\Transit\Provider;


use Illuminate\Support\ServiceProvider;
use Kenarkose\Transit\Service\DownloadService;
use Kenarkose\Transit\Service\UploadService;

class TransitServiceProvider extends ServiceProvider {

    const version = '1.0.0';

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
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/templates', '_transit');

        $this->publishes([
            dirname(__DIR__) . '/Support/config.php' => config_path('transit.php')
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
        $this->app->bindShared('transit.upload', function ()
        {
            return $this->configureUploadService(new UploadService);
        });
    }

    /**
     * Configures an upload service instance
     *
     * @param UploadService $upload
     * @return UploadService
     */
    protected function configureUploadService(UploadService $upload)
    {
        if ($validates = config('transit.validates'))
        {
            $upload->validatesUploadedFile($validates);
        }

        if ($size = config('transit.max_size'))
        {
            $upload->maxUploadSize($size);
        }

        if ($extensions = config('transit.extensions'))
        {
            $upload->allowedExtensions($extensions);
        }

        if ($mimes = config('transit.mimetypes'))
        {
            $upload->allowedMimeTypes($mimes);
        }

        if ($modelName = config('transit.model'))
        {
            $upload->modelName($modelName);
        }

        return $upload;
    }

    /**
     * Registers download service
     */
    protected function registerDownloadService()
    {
        $this->app->bindShared('transit.download', function ()
        {
            return $this->configureDownloadService(new DownloadService);
        });
    }

    /**
     * Configures a download service
     *
     * @param DownloadService $download
     * @return DownloadService
     */
    protected function configureDownloadService(DownloadService $download)
    {
        if ($modelName = config('transit.model'))
        {
            $download->modelName($modelName);
        }

        return $download;
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