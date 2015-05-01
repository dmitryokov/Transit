<?php

use org\bovigo\vfs\content\LargeFileContent;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadServiceTest extends TestBase {

    protected $uploadService;
    protected $root;

    public function setUp()
    {
        parent::setUp();

        $this->root = vfsStream::setup('root_dir', null, [
            'foo.txt' => 'foobar',
            'bar.php' => '<?php echo "bar";'
        ]);

        vfsStream::newFile('large.txt')
            ->withContent(LargeFileContent::withMegabytes(100))
            ->at($this->root);

        app()['path.upload'] = vfsStream::url('root_dir') . '/upload';

        $this->uploadService = app()->make('transit.upload');
    }

    /** @test */
    function it_gets_and_sets_validation_mode()
    {
        $this->assertTrue(
            $this->uploadService->validatesUploadedFile()
        );

        $this->assertFalse(
            $this->uploadService->validatesUploadedFile(false)
        );

        $this->assertFalse(
            $this->uploadService->validatesUploadedFile()
        );
    }

    /** @test */
    function it_gets_and_sets_max_upload_size()
    {
        $this->assertEquals(
            $this->uploadService->maxUploadSize(),
            UploadedFile::getMaxFilesize()
        );

        $this->assertEquals(
            $this->uploadService->validatesUploadedFile(50000),
            50000
        );

        $this->assertEquals(
            $this->uploadService->validatesUploadedFile(),
            50000
        );
    }

    /** @test */
    function it_gets_and_set_allowed_extensions()
    {
        $this->assertContains(
            'txt',
            $this->uploadService->allowedExtensions()
        );

        $this->assertContains(
            'jpg',
            $this->uploadService->allowedExtensions(['jpg', 'txt'])
        );

        $this->assertContains(
            'jpg',
            $this->uploadService->allowedExtensions()
        );
    }

    /** @test */
    function it_gets_and_set_allowed_mimetypes()
    {
        $this->assertContains(
            'text/plain',
            $this->uploadService->allowedMimeTypes()
        );

        $this->assertContains(
            'image/jpeg',
            $this->uploadService->allowedMimeTypes(['text/plain', 'image/jpeg'])
        );

        $this->assertContains(
            'image/jpeg',
            $this->uploadService->allowedMimeTypes()
        );
    }

    /** @test */
    function it_gets_and_sets_model_name()
    {
        $this->assertEquals(
            'Kenarkose\Transit\Model\File',
            $this->uploadService->modelName()
        );

        $this->assertEquals(
            'UploadableItem',
            $this->uploadService->modelName('UploadableItem')
        );

        $this->assertEquals(
            'UploadableItem',
            $this->uploadService->modelName()
        );
    }

    /** @test */
    function it_uploads_files()
    {
        $filePath = vfsStream::url('root_dir') . '/foo.txt';

        $uploadedFile = new UploadedFile($filePath, 'foo.txt', null, null, null, true);

        $upload = $this->uploadService->upload($uploadedFile);

        $this->assertInstanceOf(
            'Kenarkose\Transit\Contract\Uploadable',
            $upload
        );

        $this->assertFileExists($upload->path);
    }

    function it_fails_uploading_files_with_invalid_extensions()
    {
        $filePath = vfsStream::url('root_dir') . '/bar.php';

        $uploadedFile = new UploadedFile($filePath, 'bar.php', null, null, null, true);

        try
        {
            $this->uploadService->upload($uploadedFile);
        } catch (Kenarkose\Transit\Exception\InvalidFileExtensionException $e)
        {
            return;
        }

        $this->fail('Expected exception is not thrown.');
    }

    function it_fails_uploading_files_with_invalid_mimetypes()
    {
        $filePath = vfsStream::url('root_dir') . '/bar.php';

        $uploadedFile = new UploadedFile($filePath, 'bar.php', null, null, null, true);

        $this->uploadService->allowedExtensions(['php']);

        try
        {
            $this->uploadService->upload($uploadedFile);
        } catch (Kenarkose\Transit\Exception\InvalidMimeTypeException $e)
        {
            return;
        }

        $this->fail('Expected exception is not thrown.');
    }

    function it_fails_uploading_files_with_exceeding_file_size()
    {
        $filePath = vfsStream::url('root_dir') . '/large.txt';

        $uploadedFile = new UploadedFile($filePath, 'large.txt', null, null, null, true);

        try
        {
            $this->uploadService->upload($uploadedFile);
        } catch (Kenarkose\Transit\Exception\MaxFileSizeExceededException $e)
        {
            return;
        }

        $this->fail('Expected exception is not thrown.');
    }

    /** @test */
    function it_can_disable_validation()
    {
        $this->uploadService->validatesUploadedFile(false);

        $filePath = vfsStream::url('root_dir') . '/bar.php';

        $uploadedFile = new UploadedFile($filePath, 'bar.php', null, null, null, true);

        try
        {
            $this->uploadService->upload($uploadedFile);
        } catch (Kenarkose\Transit\Exception\InvalidExtensionException $e)
        {
            $this->fail('Validation exception was thrown when validation was disabled.');
        }
    }

}