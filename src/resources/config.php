<?php

return [

    /*
	|--------------------------------------------------------------------------
	| File Model
	|--------------------------------------------------------------------------
	|
	| Supply the full name of the Eloquent model that will be used by Transit
    | when uploading and downloading files. Any model that can be used by Transit
    | must extend the default 'Kenarkose\Transit\Model\File' model.
	|
	*/
    'model' => 'Kenarkose\Transit\Model\File',


    /*
	|--------------------------------------------------------------------------
	| Uploaded File Validation
	|--------------------------------------------------------------------------
	|
	| If you want Transit to handle uploaded file validation, set this setting
    | to true. Otherwise if you wish to handle validation yourself set this to
    | false. See the default validation parameters below.
	|
	*/
    'validates' => true,


    /*
	|--------------------------------------------------------------------------
	| Maximum Allowed Upload File Size
	|--------------------------------------------------------------------------
	|
    | If the 'validates' option is set to 'true', this option is used
	| to limit the maximum allowed file size for upload. It chooses
    | the minimum value between the one configured here and the return
    | value of Symfony\Component\HttpFoundation\File\UploadedFile::getMaxFilesize().
    | Supply this value in bytes.
	|
	*/
    'max_size' => 10485760,


    /*
	|--------------------------------------------------------------------------
	| Allowed File Extensions
	|--------------------------------------------------------------------------
	|
	| If the 'validates' option is set to 'true', this option is used to
    | validate file extensions allowed for upload.
	|
	*/
    'extensions' => [
        'jpg', 'jpeg', 'png', 'gif', 'bmp',
        'txt', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'
    ],


    /*
	|--------------------------------------------------------------------------
	| Allowed File Mime Types
	|--------------------------------------------------------------------------
	|
	| If the 'validates' option is set to 'true', this option is used to
    | validates file mime types allowed for upload.
	|
	*/
    'mimetypes' => [
        'image/jpeg', 'image/gif', 'image/png', 'image/bmp',
        'text/plain', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint'
    ]

];