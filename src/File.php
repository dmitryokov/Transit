<?php

namespace Kenarkose\Transit;


use Illuminate\Database\Eloquent\Model as Eloquent;

class File extends Eloquent {

    /**
     * The fillable fields for the model.
     *
     * @var array
     */
    protected $fillable = ['extension', 'mimetype', 'size', 'filename'];

    /**
     * Path accessor
     *
     * @param string $value
     * @return string
     */
    public function getPathAttribute($value)
    {
        return upload_path($value);
    }

    /**
     * Returns the file path of the file
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getAttribute('path');
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->getAttribute('filename') . '.' . $this->getAttribute('extension');
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->getAttribute('mimetype');
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return (int)$this->getAttribute('size');
    }
}