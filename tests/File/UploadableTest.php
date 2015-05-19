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

}