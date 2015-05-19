<?php

class FileTest extends TestBase {

    /** @test */
    function it_is_initializable()
    {
        $this->assertInstanceOf(
            'Kenarkose\Transit\File\File',
            new Kenarkose\Transit\File\File()
        );
    }

}