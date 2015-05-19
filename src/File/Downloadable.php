<?php

namespace Kenarkose\Transit\File;


trait Downloadable {

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
     * Getter for file path
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->getAttribute('path');
    }

    /**
     * Getter for file name
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->getAttribute('name');
    }

    /**
     * Getter for file extension
     *
     * @return string
     */
    public function getFileExtension()
    {
        return $this->getAttribute('extension');
    }

    /**
     * Getter for file mime type
     *
     * @return string
     */
    public function getFileMimeType()
    {
        return $this->getAttribute('mimetype');
    }

    /**
     * Getter for file size in bytes
     *
     * @return int
     */
    public function getFileSize()
    {
        return (int)$this->getAttribute('size');
    }

}