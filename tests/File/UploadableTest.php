<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UploadableTest extends TestBase {

    /** @test */
    function it_saves_file_data()
    {
        $attributes = [
            'extension' => 'txt',
            'mimetype'  => 'text/plain',
            'size'      => 1337,
            'name'      => 'test',
            'path'      => 'path/to/test.txt'
        ];

        $upload = new UploadableItem;

        $upload->saveUploadData($attributes);

        $this->assertEquals(
            $upload->extension,
            $attributes['extension']
        );

        try
        {
            UploadableItem::findOrFail($upload->getKey());
        } catch (ModelNotFoundException $e)
        {
            $this->fail('Uploadable model was not saved to database');
        }
    }

    /** @test */
    function it_sets_the_key()
    {
        $upload = new UploadableItem;

        $this->assertNull(
            $upload->getKey()
        );

        $upload->setKey(1337);

        $this->assertEquals(
            1337,
            $upload->getKey()
        );

        $attributes = [
            'extension' => 'txt',
            'mimetype'  => 'text/plain',
            'size'      => 1337,
            'name'      => 'test',
            'path'      => 'path/to/test.txt'
        ];

        $upload->saveUploadData($attributes);

        try
        {
            UploadableItem::findOrFail($upload->getKey());
        } catch (ModelNotFoundException $e)
        {
            $this->fail('Uploadable model was not saved to database');
        }
    }

}