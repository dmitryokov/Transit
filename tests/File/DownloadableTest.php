<?php

class DownloadableTest extends TestBase {

    protected $modelAttributes;
    protected $model;

    public function setUp()
    {
        parent::setUp();

        $this->modelAttributes = [
            'extension' => 'txt',
            'mimetype'  => 'text/plain',
            'size'      => 1337,
            'name'      => 'test',
            'path'      => 'path/to/test.txt'
        ];

        $this->model = DownloadableItem::create($this->modelAttributes);
    }

    /** @test */
    function it_returns_correct_file_path()
    {
        $this->assertEquals(
            upload_path($this->modelAttributes['path']),
            $this->model->getFilePath()
        );
    }

    /** @test */
    function it_returns_file_name()
    {
        $this->assertEquals(
            $this->modelAttributes['name'],
            $this->model->getFileName()
        );
    }

    /** @test */
    function it_returns_file_extension()
    {
        $this->assertEquals(
            $this->modelAttributes['extension'],
            $this->model->getFileExtension()
        );
    }

    /** @test */
    function it_returns_file_mime_type()
    {
        $this->assertEquals(
            $this->modelAttributes['mimetype'],
            $this->model->getFileMimeType()
        );
    }

    /** @test */
    function it_returns_file_size()
    {
        $filesize = $this->model->getFileSize();

        $this->assertEquals(
            $this->modelAttributes['size'],
            $filesize
        );

        $this->assertInternalType('int', $filesize);
    }

}