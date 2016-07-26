<?php


namespace Kenarkose\Transit\File;


trait HasMetadata {

    /**
     * Metadata cache of the file
     *
     * @param array
     */
    protected $metadataCache = null;

    /**
     * Boot the model
     */
    public static function bootHasMetadata()
    {
        static::saving(function ($file)
        {
            $file->compileMetadata();
        });
    }

    /**
     * Getter for the metadata
     *
     * @param string $key
     * @return mixed
     */
    public function getMetadata($key = null)
    {
        if (is_null($this->metadataCache))
        {
            $this->metadataCache = json_decode($this->metadata);
        }

        if (is_null($key))
        {
            return $this->metadataCache;
        }

        if (isset($this->metadataCache[$key]))
        {
            return $this->metadataCache[$key];
        }

        return null;
    }

    /**
     * Setter for metadata
     *
     * @param string $key
     * @param mixed $value
     */
    public function setMetadata($key, $value)
    {
        if (is_null($this->metadataCache))
        {
            $this->metadataCache = [];
        }

        $this->metadataCache[$key] = $value;
    }

    /**
     * Compiles metadata
     */
    public function compileMetadata()
    {
        if (is_null($this->metadataCache))
        {
            $this->metadata = '{}';

            return;
        }

        $this->metadata = json_encode($this->metadataCache);
    }

}