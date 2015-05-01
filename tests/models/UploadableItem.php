<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Kenarkose\Transit\Contract\Uploadable as UploadableContract;
use Kenarkose\Transit\Model\Uploadable;

class UploadableItem extends Eloquent implements UploadableContract {

    use Uploadable;

    /**
     * The fillable fields for the model.
     *
     * @var array
     */
    protected $fillable = ['extension', 'mimetype', 'size', 'name', 'path'];

    protected $table = 'files';

}