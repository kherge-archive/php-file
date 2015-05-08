<?php

namespace KHerGe\File;

use KHerGe\File\Exception\FileException;

/**
 * Provides additional functionality not part of the SplFileObject class.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Utility
{
    /**
     * Recursively removes a path from the file system.
     *
     * @param string $path The path to remove.
     *
     * @throws FileException If the path could not be removed.
     */
    public static function remove($path)
    {
        if (is_dir($path)) {
            if (false === ($dir = opendir($path))) {
                throw FileException::removeFailed($path);
            }

            while (false !== ($item = readdir($dir))) {
                if (('.' === $item) || ('..' === $item)) {
                    continue;
                }

                self::remove($path . DIRECTORY_SEPARATOR . $item);
            }

            closedir($dir);

            if (!rmdir($path)) {
                throw FileException::removeFailed($path);
            }
        } elseif (!unlink($path)) {
            throw FileException::removeFailed($path);
        }
    }
}
