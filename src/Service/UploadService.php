<?php

namespace Kenarkose\Transit\Service;


use Illuminate\Config\Repository;
use Kenarkose\Transit\Contract\Uploadable;
use Kenarkose\Transit\Exception\InvalidExtensionException;
use Kenarkose\Transit\Exception\InvalidMimeTypeException;
use Kenarkose\Transit\Exception\InvalidUploadException;
use Kenarkose\Transit\Exception\MaxFileSizeExceededException;
use RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService {

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var bool
     */
    protected $validatesUploadedFile = true;

    /**
     * @var int
     */
    protected $maxUploadSize;

    /**
     * @var array
     */
    protected $allowedExtensions = [
        'jpg', 'jpeg', 'png', 'gif', 'bmp',
        'txt', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'
    ];

    protected $allowedMimeTypes = [
        'image/jpeg', 'image/gif', 'image/png', 'image/bmp',
        'text/plain', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint'
    ];

    /**
     * @var string
     */
    protected $modelName = 'Kenarkose\Transit\File\File';

    /**
     * Constructor
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;

        if ($validates = $this->config->get('transit.validates'))
        {
            $this->validatesUploadedFile($validates);
        }

        if ($extensions = $this->config->get('transit.extensions'))
        {
            $this->allowedExtensions($extensions);
        }

        if ($mimes = $this->config->get('transit.mimetypes'))
        {
            $this->allowedMimeTypes($mimes);
        }

        if ($modelName = $this->config->get('transit.model'))
        {
            $this->modelName($modelName);
        }

        $size = $this->config->get('transit.max_size', UploadedFile::getMaxFilesize());

        $this->maxUploadSize($size);
    }

    /**
     * Sets and gets validation mode
     *
     * @param bool $validate
     * @return bool
     */
    public function validatesUploadedFile($validate = null)
    {
        if (func_num_args() === 0)
        {
            return $this->validatesUploadedFile;
        }

        return $this->validatesUploadedFile = (bool)$validate;
    }

    /**
     * @param int $size
     * @return int
     */
    public function maxUploadSize($size = null)
    {
        if (func_num_args() === 0)
        {
            return $this->maxUploadSize;
        }

        return $this->maxUploadSize = min(
            (int)$size,
            UploadedFile::getMaxFilesize()
        );
    }

    /**
     * @param array $extensions
     * @return array
     */
    public function allowedExtensions($extensions = null)
    {
        if (func_num_args() === 0)
        {
            return $this->allowedExtensions;
        }

        return $this->allowedExtensions = (array)$extensions;
    }

    /**
     * @param array $mimetypes
     * @return array
     */
    public function allowedMimeTypes($mimetypes = null)
    {
        if (func_num_args() === 0)
        {
            return $this->allowedMimeTypes;
        }

        return $this->allowedMimeTypes = (array)$mimetypes;
    }

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

    /**
     * Uploads a file
     *
     * @param UploadedFile $uploadedFile
     * @return Upload
     */
    public function upload(UploadedFile $uploadedFile)
    {
        if ($this->validatesUploadedFile())
        {
            $this->validateUploadedFile($uploadedFile);
        }

        return $this->processUpload($uploadedFile);
    }

    /**
     * @param UploadedFile $uploadedFile
     * @throws InvalidUploadException
     * @throws MaxFileSizeExceededException
     * @throws InvalidExtensionException
     * @throws InvalidMimeTypeException
     */
    protected function validateUploadedFile(UploadedFile $uploadedFile)
    {
        if ( ! $uploadedFile->isValid())
        {
            throw new InvalidUploadException($uploadedFile->getErrorMessage());
        }

        if ($this->maxUploadSize() < $uploadedFile->getSize())
        {
            throw new MaxFileSizeExceededException('Uploaded file exceeded maximum allowed upload size.');
        }

        if ( ! in_array($uploadedFile->getExtension(), $this->allowedExtensions()))
        {
            throw new InvalidExtensionException('Files with extension (' . $uploadedFile->getExtension() . ') are not allowed');
        }

        if ( ! in_array($uploadedFile->getMimeType(), $this->allowedMimeTypes()))
        {
            throw new InvalidMimeTypeException('Files with mime type (' . $uploadedFile->getMimeType() . ' are not allowed');
        }
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return Upload
     */
    protected function processUpload(UploadedFile $uploadedFile)
    {
        $uploadData = $this->prepareUploadData($uploadedFile);

        $uploadData['path'] = $this->moveUploadedFile($uploadedFile);

        $upload = $this->saveUpload($uploadData);

        return $upload;
    }

    /**
     * Returns an array of data for upload model
     *
     * @param UploadedFile $uploadedFile
     * @return array
     */
    protected function prepareUploadData(UploadedFile $uploadedFile)
    {
        return [
            'extension' => $uploadedFile->getExtension(),
            'mimetype'  => $uploadedFile->getMimeType(),
            'size'      => $uploadedFile->getSize(),
            'name'      => $uploadedFile->getBasename('.' . $uploadedFile->getExtension()),
        ];
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return array
     */
    protected function moveUploadedFile(UploadedFile $uploadedFile)
    {
        list($fullPath, $relativePath) = $this->getUploadPath();

        $filename = md5(uniqid(mt_rand(), true))
            . '.' . $uploadedFile->getClientOriginalExtension();

        $uploadedFile->move($fullPath, $filename);

        return $relativePath . '/' . $filename;
    }

    /**
     * Returns the current upload directory
     *
     * @return string
     */
    protected function getUploadPath()
    {
        $relativePath = date('Y/m');
        $fullPath = upload_path($relativePath);

        $this->makeUploadPath($fullPath);

        return [$fullPath, $relativePath];
    }

    /**
     * Creates the current upload directory
     *
     * @param $uploadPath
     * @throws RuntimeException
     */
    protected function makeUploadPath($uploadPath)
    {
        if ( ! file_exists($uploadPath))
        {
            if ( ! mkdir($uploadPath, 0777, true))
            {
                throw new RuntimeException('Directory (' . $uploadPath . ') could not be created.');
            }
        }
    }

    /**
     * @param array $uploadData
     * @return mixed
     */
    protected function saveUpload(array $uploadData)
    {
        $upload = $this->getNewUploadModel();

        $upload->saveUploadData($uploadData);

        return $upload;
    }

    /**
     * Creates a new upload model
     *
     * @return mixed
     */
    protected function getNewUploadModel()
    {
        $uploadModel = $this->modelName();

        $upload = new $uploadModel;

        if ( ! $upload instanceof Uploadable)
        {
            throw new RuntimeException('The upload model must implement the "Kenarkose\Transit\Contract\Uploadable" interface.');
        }

        return $upload;
    }

}
