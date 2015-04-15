<?php

if ( ! function_exists('upload_path'))
{
    /**
     * Get the path to the upload folder.
     *
     * @param string $path
     * @return string
     */
    function upload_path($path = '')
    {
        return app()->make('path.upload') . ($path ? '/' . $path : $path);
    }
}