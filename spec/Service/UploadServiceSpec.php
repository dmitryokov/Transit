<?php

namespace spec\Kenarkose\Transit\Service;


use Illuminate\Support\Facades\Artisan;
use org\bovigo\vfs\content\LargeFileContent;
use org\bovigo\vfs\vfsStream;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadServiceSpec extends LaravelObjectBehavior {

    function let()
    {
        $root = vfsStream::setup('root_dir', null, [
            'foo.txt' => 'foobar',
            'bar.txt' => 'barfoo',
            'bar.php' => '<?php echo "bar";'
        ]);

        vfsStream::newFile('large.txt')
            ->withContent(LargeFileContent::withMegabytes(100))
            ->at($root);

        app()['path.upload'] = vfsStream::url('root_dir') . '/upload';


        Artisan::call('migrate');


        $this->allowedMimeTypes(['text/plain']);
        $this->allowedExtensions(['txt']);

        $this->maxUploadSize(100000);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kenarkose\Transit\Service\UploadService');
    }

    function it_gets_and_sets_validate_mode()
    {
        $this->validatesUploadedFile()->shouldBe(true);

        $this->validatesUploadedFile(false)->shouldBe(false);

        $this->validatesUploadedFile()->shouldBe(false);
    }

    function it_gets_and_sets_max_upload_size()
    {
        $this->maxUploadSize()->shouldBe(100000);

        $this->maxUploadSize(50000)->shouldBe(50000);

        $this->maxUploadSize()->shouldBe(50000);
    }

    function it_gets_and_set_allowed_extensions()
    {
        $this->allowedExtensions()->shouldContain('txt');

        $this->allowedExtensions(['html'])->shouldContain('html');

        $this->allowedExtensions()->shouldContain('html');
    }

    function it_gets_and_set_allowed_mimetypes()
    {
        $this->allowedMimeTypes()->shouldContain('text/plain');

        $this->allowedMimeTypes(['application/pdf'])->shouldContain('application/pdf');

        $this->allowedMimeTypes()->shouldContain('application/pdf');
    }

    function it_uploads_files()
    {
        $filePath = vfsStream::url('root_dir') . '/foo.txt';

        $file = new UploadedFile($filePath, 'foo.txt', null, null, null, true);

        $this->upload($file)->shouldBeAnInstanceOf('Kenarkose\Transit\File');


        $filePath = vfsStream::url('root_dir') . '/bar.txt';

        $file = new UploadedFile($filePath, 'bar.txt', null, null, null, true);

        $this->upload($file)->shouldMoveFile();
    }

    function it_fails_uploading_files_with_invalid_extensions()
    {
        $filePath = vfsStream::url('root_dir') . '/bar.php';

        $file = new UploadedFile($filePath, 'bar.php', null, null, null, true);

        $this->shouldThrow('Kenarkose\Transit\Exception\InvalidExtensionException')->duringUpload($file);
    }

    function it_fails_uploading_files_with_invalid_mimetypes()
    {
        $filePath = vfsStream::url('root_dir') . '/bar.php';

        $file = new UploadedFile($filePath, 'bar.php', null, null, null, true);


        $this->allowedExtensions(['php']);
        $this->shouldThrow('Kenarkose\Transit\Exception\InvalidMimeTypeException')->duringUpload($file);
    }

    function it_fails_uploading_files_with_exceeding_file_size()
    {
        $filePath = vfsStream::url('root_dir') . '/large.txt';

        $file = new UploadedFile($filePath, 'large.txt', null, null, null, true);

        $this->shouldThrow('Kenarkose\Transit\Exception\MaxFileSizeExceededException')->duringUpload($file);
    }

    public function getMatchers()
    {
        return [
            'moveFile' => function ($file)
            {
                return file_exists($file->getPath());
            }
        ];
    }

}
