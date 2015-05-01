<?php

namespace Kenarkose\Transit\Model;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Kenarkose\Transit\Contract\Downloadable as DownloadableContract;
use Kenarkose\Transit\Contract\Uploadable as UploadableContract;

class File extends Eloquent implements DownloadableContract, UploadableContract {

    use Downloadable, Uploadable;

    /**
     * The fillable fields for the model.
     *
     * @var array
     */
    protected $fillable = ['extension', 'mimetype', 'size', 'name', 'path'];

}