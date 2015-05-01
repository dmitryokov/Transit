<?php

class TransitServiceProviderTest extends TestBase {

    /** @test */
    function it_registers_upload_path()
    {
        $this->assertStringStartsWith(base_path(), app('path.upload'));
        $this->assertInternalType('string', app('path.upload'));
    }

    /** @test */
    function it_registers_upload_service()
    {
        $this->assertInstanceOf(
            'Kenarkose\Transit\Service\UploadService',
            app()->make('transit.upload')
        );
    }

    /** @test */
    function it_registers_download_service()
    {
        $this->assertInstanceOf(
            'Kenarkose\Transit\Service\DownloadService',
            app()->make('transit.download')
        );
    }

}