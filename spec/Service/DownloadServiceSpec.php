<?php

namespace spec\Kenarkose\Transit\Service;


use Illuminate\Support\Facades\Artisan;
use Kenarkose\Transit\Service\UploadService;
use org\bovigo\vfs\vfsStream;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DownloadServiceSpec extends LaravelObjectBehavior {

    function let()
    {
        vfsStream::setup('root_dir', null, [
            'foo.txt' => 'foobar'
        ]);

        app()['path.upload'] = vfsStream::url('root_dir') . '/upload';

        Artisan::call('migrate');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kenarkose\Transit\Service\DownloadService');
    }

    function it_downloads_a_file_by_model()
    {
        $filePath = vfsStream::url('root_dir') . '/foo.txt';

        $file = new UploadedFile($filePath, 'foo.txt', null, null, null, true);

        $uploader = new UploadService;
        $uploader->allowedMimeTypes(['text/plain']);
        $uploader->allowedExtensions(['txt']);
        $uploader->maxUploadSize(100000);

        $upload = $uploader->upload($file);

        $this->download($upload)->shouldBeAnInstanceOf('Symfony\Component\HttpFoundation\BinaryFileResponse');
    }

    function it_downloads_a_file_by_id()
    {
        $filePath = vfsStream::url('root_dir') . '/foo.txt';

        $file = new UploadedFile($filePath, 'foo.txt', null, null, null, true);

        $uploader = new UploadService;
        $uploader->allowedMimeTypes(['text/plain']);
        $uploader->allowedExtensions(['txt']);
        $uploader->maxUploadSize(100000);

        $upload = $uploader->upload($file);

        $this->download($upload->getKey())->shouldBeAnInstanceOf('Symfony\Component\HttpFoundation\BinaryFileResponse');
    }

    function it_validates_download_input()
    {
        $this->shouldThrow('InvalidArgumentException')->duringDownload(new Foo);
        $this->shouldThrow('InvalidArgumentException')->duringDownload(true);
        $this->shouldThrow('InvalidArgumentException')->duringDownload([]);
    }

    function it_fails_to_download_non_existing_files()
    {
        $this->shouldThrow('Illuminate\Database\Eloquent\ModelNotFoundException')->duringDownload(0);
    }

}


class Foo {}