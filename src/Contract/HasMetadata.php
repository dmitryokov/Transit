<?php


namespace Kenarkose\Transit\Contract;


interface HasMetadata {

    /**
     * Getter for the metadata
     *
     * @param string $key
     * @return mixed
     */
    public function getMetadata($key = null);

    /**
     * Setter for metadata
     *
     * @param string $key
     * @param mixed $value
     */
    public function setMetadata($key, $value);

    /**
     * Compiles metadata
     */
    public function compileMetadata();

}