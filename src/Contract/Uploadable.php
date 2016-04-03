<?php

namespace Kenarkose\Transit\Contract;


interface Uploadable {

    /**
     * Sets the upload primary key
     *
     * @param int $id
     */
    public function setKey($id);

    /**
     * Saves upload data to model
     *
     * @param array $data
     */
    public function saveUploadData(array $data);

}