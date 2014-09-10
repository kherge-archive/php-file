<?php

namespace KHerGe\File\Tests;

use KHerGe\File\TempFile;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Verifies that the TempFile class functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @covers KHerGe\File\TempFile
 *
 * @uses KHerGe\File\File
 */
class TempFileTest extends TestCase
{
    /**
     * Verifies that a temporary stream is used, then an actual file.
     *
     * @covers KHerGe\File\TempFile::__construct
     */
    public function testConstruct()
    {
        $file = new TempFile(1);

        $this->assertEquals('php://temp/maxmemory:1', $file->getPathname());

        $before = count(scandir(sys_get_temp_dir()));

        $file->fwrite('abc');

        $after = count(scandir(sys_get_temp_dir()));

        $this->assertGreaterThan($before, $after);
    }
}
