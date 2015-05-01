<?php

namespace Kenarkose\Transit\Model;


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