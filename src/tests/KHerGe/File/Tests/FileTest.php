<?php

namespace KHerGe\File\Tests;

use KHerGe\File\File;
use KHerGe\File\Test\TestStream;
use PHPUnit_Framework_Error_Warning as Warning;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Verifies that the File class functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @covers KHerGe\File\File
 */
class FileTest extends TestCase
{
    /**
     * A test file.
     *
     * @var string
     */
    private $file;

    /**
     * Verifies that an exception is thrown on open error.
     *
     * @covers KHerGe\File\File::__construct
     */
    public function testConstruct()
    {
        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            'The file "/does/not/exist" could not be opened.'
        );

        new File('/does/not/exist');
    }

    /**
     * Verifies that we can create a new file object.
     *
     * @covers KHerGe\File\File::create
     */
    public function testCreate()
    {
        $this->assertInstanceOf(
            'KHerGe\File\File',
            File::create($this->file)
        );
    }

    /**
     * Verifies that we can create a new temporary file object.
     *
     * @covers KHerGe\File\File::createTemp
     */
    public function testCreateTemp()
    {
        $file = File::createTemp(1);

        $this->assertInstanceOf(
            'KHerGe\File\File',
            $file
        );

        $this->assertStringStartsWith(
            sys_get_temp_dir(),
            $file->getPathname()
        );

        unlink($file->getPathname());
    }

    /**
     * Verifies that we can create a new, named temporary file object.
     *
     * @covers KHerGe\File\File::createTempNamed
     */
    public function testCreateTempNamed()
    {
        $file = File::createTempNamed('test.php');

        $this->assertInstanceOf(
            'KHerGe\File\File',
            $file
        );

        $this->assertStringStartsWith(
            sys_get_temp_dir(),
            $file->getPathname()
        );

        $this->assertStringEndsWith(
            'test.php',
            $file->getPathname()
        );

        unlink($file->getPathname());
    }

    /**
     * Verifies that we can create a new temporary file path.
     *
     * @covers KHerGe\File\File::createTempPath
     */
    public function testCreateTempPath()
    {
        $file = File::createTempPath('taco-');

        $this->assertStringStartsWith(sys_get_temp_dir(), $file);
        $this->assertContains('taco-', $file);

        unlink($file);
    }

    /**
     * Verifies that we can create a new, named temporary file path.
     *
     * @covers KHerGe\File\File::createTempPathNamed
     */
    public function testCreateTempPathNamed()
    {
        $file = File::createTempPathNamed('test.php');

        $this->assertStringStartsWith(sys_get_temp_dir(), $file);
        $this->assertStringEndsWith('test.php', $file);

        unlink($file);
    }

    /**
     * Verifies that a failed flush throws an exception.
     *
     * @covers KHerGe\File\File::fflush
     */
    public function testFflush()
    {
        $file = new File($this->file);

        $this->assertTrue(
            $file->fflush(),
            'The file should have successfully flushed.'
        );

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The file \"TestStream://{$this->file}\" could not be flushed."
        );

        $file = new File('TestStream://' . $this->file);
        $file->fflush();
    }

    /**
     * Verifies that a failed read throws an exception.
     *
     * @covers KHerGe\File\File::fgetc
     */
    public function testFgetc()
    {
        file_put_contents($this->file, 't');

        $file = new File($this->file);

        $this->assertEquals(
            't',
            $file->fgetc(),
            'A character should have still been returned.'
        );

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The end of the file, \"{$this->file}\", has been reached."
        );

        $file->fgetc();
    }

    /**
     * Verifies that a failed read throws an exception.
     *
     * @covers KHerGe\File\File::fgetcsv
     */
    public function testFgetcsv()
    {
        file_put_contents($this->file, '1,2,3');

        $file = new File($this->file);

        $this->assertEquals(
            array(1, 2, 3),
            $file->fgetcsv(),
            'The CSV row should have still been returned.'
        );

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The file \"TestStream://{$this->file}\" could not be read."
        );

        TestStream::$eof = true;

        $file = new File('TestStream://' . $this->file);
        $file->fgetcsv();
    }

    /**
     * Verifies that a failed read throws an exception.
     *
     * @covers KHerGe\File\File::fgets
     */
    public function testFgets()
    {
        file_put_contents($this->file, 'test');

        $file = new File($this->file);

        $this->assertEquals(
            'test',
            $file->fgets(),
            'A string should have still been returned.'
        );

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The file \"{$this->file}\" could not be read."
        );

        $file->fgets();
    }

    /**
     * Verifies that a failed read throws an exception.
     *
     * @covers KHerGe\File\File::fgetss
     */
    public function testFgetss()
    {
        file_put_contents($this->file, '<span><a>test</a></span>');

        $file = new File($this->file);

        $this->assertEquals(
            'test',
            $file->fgetss(),
            'A stripped string should have still been returned.'
        );

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The file \"{$this->file}\" could not be read."
        );

        $file->fgetss();
    }

    /**
     * Verifies that a failed lock throws an exception.
     *
     * @covers KHerGe\File\File::flock
     */
    public function testFlock()
    {
        $file = new File($this->file);

        $this->assertTrue(
            $file->flock(LOCK_UN),
            'The first lock should have been successful.'
        );

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The file \"{$this->file}\" could not be (un)locked."
        );

        @$file->flock(LOCK_NB);
    }

    /**
     * Verifies that a failed write throws an exception.
     *
     * @covers KHerGe\File\File::fputcsv
     */
    public function testFputcsv()
    {
        $file = new File($this->file, 'w');

        $this->assertEquals(
            6,
            $file->fputcsv(array('a d')),
            'The number of bytes written should have been returned.'
        );

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The file \"TestStream://{$this->file}\" could not be written to."
        );

        $file = new File('TestStream://' . $this->file);
        @$file->fputcsv(array('test'), ',,');
    }

    /**
     * Verifies that a failed seek throws an exception.
     *
     * @covers KHerGe\File\File::fseek
     */
    public function testFseek()
    {
        $file = new File($this->file);

        $this->assertEquals(
            0,
            $file->fseek(0),
            'The initial seek should be successful.'
        );

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The file \"{$this->file}\" could not be seeked."
        );

        $file->fseek(-1);
    }

    /**
     * Verifies that a ftell still works.
     *
     * Can't verify that an exception is thrown, unfortunately.
     *
     * @covers KHerGe\File\File::ftell
     */
    public function testFtell()
    {
        $file = new File($this->file);

        $this->assertEquals(
            0,
            $file->ftell(),
            'The first tell should return the offset.'
        );
    }

    /**
     * Verifies that a failed truncate throws an exception.
     *
     * @covers KHerGe\File\File::ftruncate
     */
    public function testFtruncate()
    {
        $file = new File($this->file, 'w');

        $this->assertTrue(
            $file->ftruncate(0),
            'The initial truncate should succeed.'
        );

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The file \"{$this->file}\" could not be truncated."
        );

        $file = new File($this->file);
        $file->ftruncate(0);
    }

    /**
     * Verifies that a failed write throws an exception.
     *
     * @covers KHerGe\File\File::fwrite
     */
    public function testFwrite()
    {
        $file = new File($this->file, 'w');

        $this->assertEquals(
            1,
            $file->fwrite('t'),
            'The initial write should succeed.'
        );

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The file \"{$this->file}\" could not be written to."
        );

        @$file->fwrite('test', 'x');
    }

    /**
     * Verifies that a failed line seek throws an exception.
     *
     * @covers KHerGe\File\File::seek
     */
    public function testSeek()
    {
        $file = new File($this->file);
        $file->seek(0);

        $this->setExpectedException(
            'KHerGe\File\Exception\FileException',
            "The file \"{$this->file}\" could not be seeked."
        );

        $file->seek(-1);
    }

    /**
     * Creates a new test file.
     */
    protected function setUp()
    {
        Warning::$enabled = false;
        TestStream::$eof = false;

        stream_wrapper_register('TestStream', 'KHerGe\File\Test\TestStream');

        $this->file = tempnam(sys_get_temp_dir(), 'file-');
    }

    /**
     * Cleans up an existing test file.
     */
    protected function tearDown()
    {
        stream_wrapper_unregister('TestStream');

        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }
}
