<?php

namespace KHerGe\File\Exception;

use Exception;
use RuntimeException;
use SplFileObject;

/**
 * Throw for file related exceptions.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @codeCoverageIgnore
 */
class FileException extends RuntimeException
{
    /**
     * Creates an exception for a failed flush.
     *
     * @param SplFileObject $file     The file object in context.
     * @param Exception     $previous The previous exception.
     *
     * @return FileException The new exception.
     */
    public static function flushFailed(
        SplFileObject $file,
        Exception $previous = null
    ) {
        return new self(
            sprintf(
                'The file "%s" could not be flushed.',
                $file->getPathname()
            ),
            0,
            $previous
        );
    }

    /**
     * Creates an exception for a failed lock.
     *
     * @param SplFileObject $file     The file object in context.
     * @param Exception     $previous The previous exception.
     *
     * @return FileException The new exception.
     */
    public static function lockFailed(
        SplFileObject $file,
        Exception $previous = null
    ) {
        return new self(
            sprintf(
                'The file "%s" could not be (un)locked.',
                $file->getPathname()
            ),
            0,
            $previous
        );
    }

    /**
     * Creates an exception for a failed max line length.
     *
     * @param SplFileObject $file     The file object in context.
     * @param Exception     $previous The previous exception.
     *
     * @return FileException The new exception.
     */
    public static function maxLineFailed(
        SplFileObject $file,
        Exception $previous = null
    ) {
        return new self(
            sprintf(
                'The file "%s" could not have its max line length set.',
                $file->getPathname()
            ),
            0,
            $previous
        );
    }

    /**
     * Creates an exception for a failed file open.
     *
     * @param string    $file     The file path.
     * @param Exception $previous The previous exception.
     *
     * @return FileException The new exception.
     */
    public static function openFailed($file, Exception $previous = null)
    {
        return new self(
            "The file \"$file\" could not be opened.",
            0,
            $previous
        );
    }

    /**
     * Creates an exception for reaching the end of the file.
     *
     * @param SplFileObject $file     The file object in context.
     * @param Exception     $previous The previous exception.
     *
     * @return FileException The new exception.
     */
    public static function reachedEOF(
        SplFileObject $file,
        Exception $previous = null
    ) {
        return new self(
            sprintf(
                'The end of the file, "%s", has been reached.',
                $file->getPathname()
            ),
            0,
            $previous
        );
    }

    /**
     * Creates an exception for a failed read.
     *
     * @param SplFileObject $file     The file object in context.
     * @param Exception     $previous The previous exception.
     *
     * @return FileException The new exception.
     */
    public static function readFailed(
        SplFileObject $file,
        Exception $previous = null
    ) {
        return new self(
            sprintf(
                'The file "%s" could not be read.',
                $file->getPathname()
            ),
            0,
            $previous
        );
    }

    /**
     * Creates an exception for a failed path removal.
     *
     * @param string $path The path that should have been removed.
     *
     * @return FileException The new exception.
     */
    public static function removeFailed($path)
    {
        return new self(
            sprintf(
                'The path "%s" could not be removed.',
                $path
            )
        );
    }

    /**
     * Creates an exception for a failed seek.
     *
     * @param SplFileObject $file     The file object in context.
     * @param Exception     $previous The previous exception.
     *
     * @return FileException The new exception.
     */
    public static function seekFailed(
        SplFileObject $file,
        Exception $previous = null
    ) {
        return new self(
            sprintf(
                'The file "%s" could not be seeked.',
                $file->getPathname()
            ),
            0,
            $previous
        );
    }

    /**
     * Creates an exception for a failed tell.
     *
     * @param SplFileObject $file     The file object in context.
     * @param Exception     $previous The previous exception.
     *
     * @return FileException The new exception.
     */
    public static function tellFailed(
        SplFileObject $file,
        Exception $previous = null
    ) {
        return new self(
            sprintf(
                'The position in the file "%s" could not be determined.',
                $file->getPathname()
            ),
            0,
            $previous
        );
    }

    /**
     * Creates an exception for a failed truncate.
     *
     * @param SplFileObject $file     The file object in context.
     * @param Exception     $previous The previous exception.
     *
     * @return FileException The new exception.
     */
    public static function truncateFailed(
        SplFileObject $file,
        Exception $previous = null
    ) {
        return new self(
            sprintf(
                'The file "%s" could not be truncated.',
                $file->getPathname()
            ),
            0,
            $previous
        );
    }

    /**
     * Creates an exception for a failed write.
     *
     * @param SplFileObject $file     The file object in context.
     * @param Exception     $previous The previous exception.
     *
     * @return FileException The new exception.
     */
    public static function writeFailed(
        SplFileObject $file,
        Exception $previous = null
    ) {
        return new self(
            sprintf(
                'The file "%s" could not be written to.',
                $file->getPathname()
            ),
            0,
            $previous
        );
    }
}
