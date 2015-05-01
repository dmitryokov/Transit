<?php

use Mockery as m;
use org\bovigo\vfs\vfsStream;

class DownloadServiceTest extends TestBase {

    public function setUp()
    {
        parent::setUp();

        vfsStream::setup('root_dir', null, [
            'foo.txt' => 'foobar'
        ]);

        app()['path.upload'] = vfsStream::url('root_dir');
    }

    protected function getDownloadable()
    {
        return m::mock('Kenarkose\Transit\Contract\Downloadable')
            ->shouldReceive('getFilePath')
            ->andReturn(vfsStream::url('root_dir') . '/foo.txt')
            ->shouldReceive('getFileName')
            ->andReturn('foo')
            ->shouldReceive('getFileExtension')
            ->andReturn('txt')
            ->shouldReceive('getFileMimeType')
            ->andReturn('text/plain')
            ->shouldReceive('getFileSize')
            ->andReturn(100)
            ->mock();
    }

    protected function getDownloadService()
    {
        return app()->make('transit.download');
    }

    /** @test */
    function it_returns_a_download_response()
    {
        $response = $this->getDownloadService()->download(
            $this->getDownloadable()
        );

        $this->assertInstanceOf(
            'Symfony\Component\HttpFoundation\BinaryFileResponse',
            $response
        );

        $this->assertEquals(
            $response->getFile(),
            vfsStream::url('root_dir') . '/foo.txt'
        );
    }

}