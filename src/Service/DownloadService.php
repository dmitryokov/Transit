<?php

namespace Kenarkose\Transit\Service;


use InvalidArgumentException;
use Kenarkose\Transit\File;

class DownloadService {

    use Configurable;

    /**
     * @param File|int $file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($file)
    {
        if ( ! $file instanceof File
            && (is_string($file) || is_int($file))
        )
        {
            $modelName = $this->modelName();

            $file = $modelName::findOrFail($file);
        }

        if ( ! $file instanceof File)
        {
            throw new InvalidArgumentException('Argument for download can only be a valid key or an instance of Kenarkose\Transit\File.');
        }

        return $this->downloadResponse($file);
    }

    /**
     * @param File $file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    protected function downloadResponse(File $file)
    {
        return response()->download(
            $file->getPath(),
            $file->getFileName(),
            [
                'Content-Description'       => 'File Transfer',
                'Content-Type'              => $file->getMimeType(),
                'Content-Transfer-Encoding' => 'binary',
                'Expires'                   => 0,
                'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
                'Pragma'                    => 'public',
                'Content-Length'            => $file->getSize()
            ]
        );
    }
}
