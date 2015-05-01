<?php

namespace Kenarkose\Transit\Contract;


interface Downloadable {

    /**
     * Getter for file path
     *
     * @return string
     */
    public function getFilePath();

    /**
     * Getter for file name
     *
     * @return string
     */
    public function getFileName();

    /**
     * Getter for file extension
     *
     * @return string
     */
    public function getFileExtension();

    /**
     * Getter for file mime type
     *
     * @return string
     */
    public function getFileMimeType();

    /**
     * Getter for file size in bytes
     *
     * @return int
     */
    public function getFileSize();

}