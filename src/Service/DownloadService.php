<?php

namespace Kenarkose\Transit\Service;


use Kenarkose\Transit\Contract\Downloadable;

class DownloadService {

    /**
     * @param Downloadable $file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Downloadable $file)
    {
        return response()->download(
            $file->getFilePath(),
            $file->getFileName(),
            $this->makeDownloadHeaders($file)
        );
    }

    /**
     * @param Downloadable $file
     * @return array
     */
    protected function makeDownloadHeaders(Downloadable $file)
    {
        return [
            'Content-Description'       => 'File Transfer',
            'Content-Type'              => $file->getFileMimeType(),
            'Content-Transfer-Encoding' => 'binary',
            'Expires'                   => 0,
            'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma'                    => 'public',
            'Content-Length'            => $file->getFileSize()
        ];
    }
}
