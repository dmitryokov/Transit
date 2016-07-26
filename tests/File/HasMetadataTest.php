<?php


class HasMetadataTest extends TestBase {

    protected function getItem()
    {
        return new ItemHasMetadata();
    }

    /** @test */
    function it_sets_and_gets_metadata()
    {
        $item = $this->getItem();

        $this->assertNull($item->getMetadata());

        $item->setMetadata('foo', 'bar');

        $this->assertEquals(
            $item->getMetadata('foo'),
            'bar'
        );

        $this->assertArrayHasKey('foo', $item->getMetadata());
        $this->assertCount(1, $item->getMetadata());
    }

    /** @test */
    function it_compiles_metadata()
    {
        $item = $this->getItem();

        $this->assertNull($item->getMetadata());

        $item->compileMetadata();

        $this->assertEquals($item->metadata, '{}');

        $item->setMetadata('foo', 'bar');

        $item->compileMetadata();

        $this->assertEquals(
            $item->metadata,
            '{"foo":"bar"}'
        );
    }

}