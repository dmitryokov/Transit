<?php

namespace Kenarkose\Transit\File;


trait Uploadable {

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