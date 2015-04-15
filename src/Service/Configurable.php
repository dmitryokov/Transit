<?php

namespace Kenarkose\Transit\Service;


trait Configurable {

    /**
     * @var string
     */
    protected $modelName = 'Kenarkose\Transit\File';

    /**
     * @param string
     * @return string
     */
    public function modelName($name = null)
    {
        if (func_num_args() === 0)
        {
            return $this->modelName;
        }

        return $this->modelName = (string)$name;
    }

}
