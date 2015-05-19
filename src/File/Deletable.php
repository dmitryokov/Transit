<?php

namespace Kenarkose\Transit\File;


trait Deletable {

    /**
     * Delete the model from the database
     * and from the filesystem
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        if ($this->deleteFile())
        {
            return parent::delete();
        }

        return false;
    }

    /**
     * Deletes the file from the filesystem
     *
     * @return bool
     */
    protected function deleteFile()
    {
        return @unlink($this->getFilePath());
    }

}