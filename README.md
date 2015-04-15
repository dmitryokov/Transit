# Transit
Easy file uploading and downloading for Laravel 5.

---
[![Build Status](https://travis-ci.org/kenarkose/Transit.svg?branch=master)](https://travis-ci.org/kenarkose/Transit)
[![Total Downloads](https://img.shields.io/packagist/dt/kenarkose/Transit.svg)](https://packagist.org/packages/kenarkose/Transit)
[![Latest Stable Version](http://img.shields.io/packagist/v/kenarkose/Transit.svg)](https://packagist.org/packages/kenarkose/Transit)

## Features
- Clean interface for uploading and downloading files
- Automated validation while uploading files
- Customization options for model and file validation.
- Generators for model and migration
- A [phpspec](http://www.phpspec.net) test suite for easy development

## Installation
Installing Transit is simple.

1. Pull this package in through [Composer](https://getcomposer.org).

    ```js
    {
        "require": {
            "kenarkose/transit": "0.9.*"
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
    
3. In order to persist the uploaded file information, you have to create a migration for the 'Kenarkose\Transit\File' model. To do so, use the following command.
    ```bash
        php artisan transit:migration
    ```
    Do not forget to migrate the database when prompted to.

4. You may access the services provided by Transit by using the supplied Facades or from the service container.
    ```php
    Uploader::upload($uploadedFile);
    
    return Downloader::download($idOfFileModel);
    return Downloader::download($fileModel);
    
    app()->make('transit.upload')->upload($uploadedFile);
    
    app()->make('transit.download')->download($idOfFileModel);
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
    Than, you will find the configuration file on the `config/transit.php` path. Additional information about the options can be found in the comments in this file. All of the options in the config file are optional, and falls back to default if not specified.

## Custom Model
You may need a custom model for your case. You can generate a new model with the following command.
```bash
    php artisan transit:model
```
If you do not want to use the generator, make sure that your model extends `Kenarkose\Transit\File` model.
Keep in mind that if you change the model you should publish the configuration file by using `php artisan vendor:publish` command and change the model path in the configuration file as well.


## License
Transit is released under [MIT License](https://github.com/kenarkose/Synthesizer/blob/master/LICENSE).