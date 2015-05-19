<?php

namespace Kenarkose\Transit\File;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Kenarkose\Transit\Contract\Deletable as DeletableContract;
use Kenarkose\Transit\Contract\Downloadable as DownloadableContract;
use Kenarkose\Transit\Contract\Uploadable as UploadableContract;

class File extends Eloquent implements DownloadableContract, UploadableContract, DeletableContract {

    use Downloadable, Uploadable, Deletable;

    /**
     * The fillable fields for the model.
     *
     * @var array
     */
    protected $fillable = ['extension', 'mimetype', 'size', 'name', 'path'];

}