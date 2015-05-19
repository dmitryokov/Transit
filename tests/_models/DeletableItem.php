<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Kenarkose\Transit\Contract\Deletable as DeletableContract;
use Kenarkose\Transit\File\Deletable;

class DeletableItem extends Eloquent implements DeletableContract {

    use Deletable;

    /**
     * The fillable fields for the model.
     *
     * @var array
     */
    protected $fillable = ['extension', 'mimetype', 'size', 'name', 'path'];

    protected $table = 'files';

    /**
     * Getter for file path
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->path;
    }
}