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

if ( ! function_exists('uploaded_asset'))
{
    /**
     * Get the asset path for uploaded file.
     *
     * @param string $path
     * @return string
     */
    function uploaded_asset($path)
    {
        return asset(app()->make('path.uploaded_asset') . '/' . $path);
    }
}

if ( ! function_exists('allowed_extensions'))
{
    /**
     * Returns an imploded list of allowed file extensions
     *
     * @param string
     * @return string
     */
    function allowed_extensions($glue = ',')
    {
        return implode($glue, app()->make('transit.upload')->allowedExtensions());
    }
}

if ( ! function_exists('readable_size'))
{
    /**
     * Returns readable file size
     *
     * @param int
     * @return string
     */
    function readable_size($size)
    {
        $unit = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB');

        return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
}

if ( ! function_exists('max_upload_size'))
{
    /**
     * Returns maximum upload size
     *
     * @return int
     */
    function max_upload_size()
    {
        return app()->make('transit.upload')->maxUploadSize();
    }
}