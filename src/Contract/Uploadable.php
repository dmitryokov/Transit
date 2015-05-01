<?php

namespace Kenarkose\Transit\Contract;


interface Uploadable {

    /**
     * Saves upload data to model
     *
     * @param array $data
     */
    public function saveUploadData(array $data);

}