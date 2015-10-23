<?php

class HelpersTest extends TestBase {

    /** @test */
    function it_registers_upload_path_helper()
    {
        $this->assertEquals(
            app()->make('path.upload'),
            upload_path()
        );
    }

    /** @test */
    function it_registers_uploaded_asset_helper()
    {
        $this->assertEquals(
            asset(app()->make('path.uploaded_asset') . '/foo.jpg'),
            uploaded_asset('foo.jpg')
        );
    }

    /** @test */
    function it_registers_allowed_extensions_helper()
    {
        $this->assertEquals(
            implode(',', app()->make('transit.upload')->allowedExtensions()),
            allowed_extensions()
        );
    }

    /** @test */
    function it_registers_readable_size_helper()
    {
        $this->assertEquals(
            '1 kB',
            readable_size(1024)
        );
    }

    /** @test */
    function it_registers_max_upload_size_helper()
    {
        $this->assertEquals(
            app()->make('transit.upload')->maxUploadSize(),
            max_upload_size()
        );
    }

}