<?php

namespace Kenarkose\Transit\Contract;


interface Deletable {

    /**
     * Delete the model from the database
     * and from the filesystem
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete();

    /**
     * Getter for file path
     *
     * @return string
     */
    public function getFilePath();

}