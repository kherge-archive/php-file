<?php

namespace KHerGe\File\Tests;

use KHerGe\File\Utility;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Verifies that the class functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class UtilityTest extends TestCase
{
    /**
     * Verifies that we can recursively delete a path.
     *
     * @covers \KHerGe\File\Utility::remove
     */
    public static function testRemove()
    {
        $file = tempnam(sys_get_temp_dir(), 'box-');

        Utility::remove($file);

        self::assertFileNotExists($file);

        unlink($dir = tempnam(sys_get_temp_dir(), 'box-'));

        mkdir($dir);
        touch($dir . '/test');

        Utility::remove($dir);

        self::assertFileNotExists($dir);
    }
}
