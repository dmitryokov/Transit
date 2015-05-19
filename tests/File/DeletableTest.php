<?php

use org\bovigo\vfs\vfsStream;

class DeletableTest extends TestBase {

    public function setUp()
    {
        parent::setUp();

        vfsStream::setup('root_dir', null, [
            'foo.txt' => 'foobar',
            'directory' => [
                'bar.txt' => 'barfoo'
            ]
        ]);

        app()['path.upload'] = vfsStream::url('root_dir');
    }

    /** @test */
    function it_deletes_the_file_and_record()
    {
        $file = DeletableItem::create([
            'extension' => 'txt',
            'mimetype'  => 'text/plain',
            'size'      => 1337,
            'name'      => 'foo',
            'path'      => vfsStream::url('root_dir/foo.txt')
        ]);

        $this->assertFileExists(
            vfsStream::url('root_dir/foo.txt')
        );

        $this->assertTrue(
            $file->delete()
        );

        $this->assertFileNotExists(
            vfsStream::url('root_dir/foo.txt')
        );
    }

    /** @test */
    function it_does_not_delete_directories()
    {
        $file = DeletableItem::create([
            'extension' => 'txt',
            'mimetype'  => 'text/plain',
            'size'      => 1337,
            'name'      => 'bar',
            'path'      => vfsStream::url('root_dir/directory')
        ]);

        $this->assertFileExists(
            vfsStream::url('root_dir/directory')
        );

        $this->assertFalse(
            $file->delete()
        );

        $this->assertFileExists(
            vfsStream::url('root_dir/directory')
        );
    }

    /** @test */
    function it_returns_false_when_non_existing_file_is_tried_to_be_deleted()
    {
        $file = DeletableItem::create([
            'extension' => 'txt',
            'mimetype'  => 'text/plain',
            'size'      => 1337,
            'name'      => 'foo',
            'path'      => vfsStream::url('root_dir/non/existing.txt')
        ]);

        $this->assertFileNotExists(
            vfsStream::url('root_dir/non/existing.txt')
        );

        $this->assertFalse(
            $file->delete()
        );
    }

}