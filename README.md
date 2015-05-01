# Transit
Easy file uploading and downloading for Laravel 5.

---
[![Build Status](https://travis-ci.org/kenarkose/Transit.svg?branch=master)](https://travis-ci.org/kenarkose/Transit)
[![Total Downloads](https://img.shields.io/packagist/dt/kenarkose/Transit.svg)](https://packagist.org/packages/kenarkose/Transit)
[![Latest Stable Version](http://img.shields.io/packagist/v/kenarkose/Transit.svg)](https://packagist.org/packages/kenarkose/Transit)

## Features
- Clean API for uploading and downloading files
- Automated(optional) validation while uploading files
- Customization options for file storage, model and validation.
- Generators for model and migration
- A [phpunit](http://www.phpunit.de) test suite for easy development

## Installation
Installing Transit is simple.

1. Pull this package in through [Composer](https://getcomposer.org).

    ```js
    {
        "require": {
            "kenarkose/transit": "1.0.*"
        }
    }
    ```

2. In order to register Transit Service Provider add `'Kenarkose\Transit\Provider\TransitServiceProvider'` to the end of `providers` array in your `config/app.php` file.
    ```php
    'providers' => array(
    
        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        ...
        'Kenarkose\Transit\Provider\TransitServiceProvider',
    
    ),
    ```
    
3. In order to persist the uploaded file information, you have to create a migration for the 'Kenarkose\Transit\Model\File' model, which is the default model used for database persistence. To do so, use the following command.
    ```bash
        php artisan transit:migration
    ```
    Do not forget to migrate the database when prompted to or after modifying the generated migration file.

4. You may access the services provided by Transit by using the supplied Facades or from the service container.
    ```php
    // Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
    Uploader::upload($uploadedFile);
    app()->make('transit.upload')->upload($uploadedFile);
    
    // Kenarkose\Transit\Contract\Downloadable $fileModel
    return Downloader::download($fileModel);
    app()->make('transit.download')->download($fileModel);
    ```

    In order to register the Facades add following the facades to the end of `aliases` array in your `config/app.php` file.
    ```php
    'aliases' => array(
    
        'App'        => 'Illuminate\Support\Facades\App',
        'Artisan'    => 'Illuminate\Support\Facades\Artisan',
        ...
        'Downloader'   => 'Kenarkose\Transit\Facade\Downloader',
        'Uploader'     => 'Kenarkose\Transit\Facade\Uploader',
    
    ),
    ```

5. Finally, you may configure the default behaviour of Transit by publishing and modifying the configuration file. To do so, use the following command. 
    ```bash
    php artisan vendor:publish
    ```
    Than, you will find the configuration file on the `config/transit.php` path. Additional information about the options can be found in the comments of this file. All of the options in the config file are optional, and falls back to default if not specified; remove an option if you would like to use the default.

6. Please check the tests and source code for further documentation.

## Custom Model
You may need a custom model for your case; for instance, when you wish to use [Ownable](https://github.com/kenarkose/Ownable). You can generate a new model for Transit with the following command.
```bash
    php artisan transit:model
```
If you do not wish to use the generator, make sure that your model implements `Kenarkose\Transit\Contract\Uploadable` interface.
Keep in mind that if you would like to use a custom model you should publish the configuration file by using `php artisan vendor:publish` command and change the class path for model in the configuration file as well. Alternatively you may configure the UploadService on runtime by using the the `modelName` method. It is required only for UploadService that you register the model name:
```php
Uploader::modelName('Custom\Uploadable\Model');
// or
app()->make('transit.upload')->modelName('Custom\Uploadable\Model');
```
You may use separate models for Upload and Download services.
But you must implement `Kenarkose\Transit\Contract\Uploadable` and `Kenarkose\Transit\Contract\Downloadable` interfaces respectively. Furthermore, you may use `Kenarkose\Transit\Model\Uploadable` and `Kenarkose\Transit\Model\Downloadable` traits for providing required functionality to Eloquent models.

## License
Transit is released under [MIT License](https://github.com/kenarkose/Synthesizer/blob/master/LICENSE).