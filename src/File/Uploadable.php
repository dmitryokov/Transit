<?php

namespace Kenarkose\Transit\File;


trait Uploadable {

    /**
     * Sets the upload primary key
     *
     * @param int $id
     */
    public function setKey($id)
    {
        $this->setAttribute(
            $this->getKeyName(),
            $id
        );
    }

    /**
     * Saves upload data to model
     *
     * @param array $data
     */
    public function saveUploadData(array $data)
    {
        $this->fill($data);

        $this->save();
    }

}