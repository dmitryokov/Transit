<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Kenarkose\Transit\Contract\Downloadable as DownloadableContract;
use Kenarkose\Transit\File\Downloadable;

class DownloadableItem extends Eloquent implements DownloadableContract {

    use Downloadable;

    /**
     * The fillable fields for the model.
     *
     * @var array
     */
    protected $fillable = ['extension', 'mimetype', 'size', 'name', 'path'];

    protected $table = 'files';

}