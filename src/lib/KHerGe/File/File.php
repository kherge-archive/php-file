<?php

namespace KHerGe\File;

use Exception;
use KHerGe\File\Exception\FileException;
use SplFileObject;

/**
 * Manages errors for read and write operations.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class File extends SplFileObject
{
    /**
     * @override
     */
    public function __construct(
        $filename,
        $open_mode = 'r',
        $use_include_path = false,
        $context = null
    ) {
        try {
            if (null === $context) {
                parent::__construct(
                    $filename,
                    $open_mode,
                    $use_include_path
                );
            } else {
                parent::__construct(
                    $filename,
                    $open_mode,
                    $use_include_path,
                    $context
                );
            }
        } catch (Exception $exception) {
            throw FileException::openFailed($filename, $exception);
        }
    }

    /**
     * Creates a new file object.
     *
     * @param string   $filename         The path to the file.
     * @param string   $open_mode        The file open mode.
     * @param boolean  $use_include_path Use the include path?
     * @param resource $context          A valid context resource.
     *
     * @return $this The new file object.
     */
    public static function create(
        $filename,
        $open_mode = 'r',
        $use_include_path = false,
        $context = null
    ) {
        return new static($filename, $open_mode, $use_include_path, $context);
    }

    /**
     * Creates a new temporary file and returns its file object.
     *
     * @param string $prefix The prefix for the name of the temporary file. (default: php-)
     * @param string $mode   The file open mode. (default: w+)
     *
     * @return $this The new file object.
     *
     * @throws FileException If the temporary file could not be created.
     */
    public static function createTemp($prefix = 'php-', $mode = 'w+')
    {
        return new static(static::createTempPath($prefix), $mode);
    }

    /**
     * Creates a new, named temporary file and returns its file object.
     *
     * @param string $name The name of the temporary file.
     * @param string $mode The file open mode. (default: w+)
     *
     * @return $this The new file object.
     */
    public static function createTempNamed($name, $mode = 'w+')
    {
        return new static(static::createTempPathNamed($name), $mode);
    }

    /**
     * Creates a new temporary file and returns its path.
     *
     * @param string $prefix The prefix for the name of the temporary file.
     *
     * @return string The path to the temporary file.
     *
     * @throws FileException If the temporary file could not be created.
     */
    public static function createTempPath($prefix = 'php-')
    {
        $temp = tempnam(sys_get_temp_dir(), $prefix);

        if (false === $temp) {
            // @codeCoverageIgnoreStart
            throw new FileException(
                'A new temporary file could not be created.'
            );
        }
        // @codeCoverageIgnoreEnd

        return $temp;
    }

    /**
     * Creates a new, named temporary file and returns its path.
     *
     * @param string $name The name for the temporary file.
     *
     * @return string The path to the temporary file.
     *
     * @throws FileException If the temporary file could not be created.
     */
    public static function createTempPathNamed($name)
    {
        $dir = static::createTempPath();

        if (!unlink($dir)) {
            // @codeCoverageIgnoreStart
            throw new FileException(
                'The temporary file could not be deleted.'
            );
        }
        // @codeCoverageIgnoreEnd

        if (!mkdir($dir)) {
            // @codeCoverageIgnoreStart
            throw new FileException(
                'A new temporary directory could not be created.'
            );
        }
        // @codeCoverageIgnoreEnd

        $path = $dir . DIRECTORY_SEPARATOR . $name;

        if (!touch($path)) {
            // @codeCoverageIgnoreStart
            throw new FileException(
                'A new temporary file could not be created.'
            );
        }
        // @codeCoverageIgnoreEnd

        return $path;
    }

    /**
     * @override
     */
    public function fflush()
    {
        if (!parent::fflush()) {
            throw FileException::flushFailed($this);
        }

        return true;
    }

    /**
     * @override
     */
    public function fgetc()
    {
        if (false === ($c = parent::fgetc())) {
            throw FileException::reachedEOF($this);
        }

        return $c;
    }

    /**
     * @override
     */
    public function fgetcsv(
        $delimiter = ',',
        $enclosure = '"',
        $escape = '\\'
    ) {
        if (!is_array($row = parent::fgetcsv($delimiter, $enclosure, $escape))) {
            throw FileException::readFailed($this);
        }

        return $row;
    }

    /**
     * @override
     */
    public function fgets()
    {
        try {
            if (false === ($string = parent::fgets())) {
                throw FileException::readFailed($this);
            }
        } catch (Exception $exception) {
            throw FileException::readFailed($this, $exception);
        }

        return $string;
    }

    /**
     * @override
     */
    public function fgetss($allowable_tags = null)
    {
        if (false === ($string = parent::fgetss($allowable_tags))) {
            throw FileException::readFailed($this);
        }

        return $string;
    }

    /**
     * @override
     */
    public function flock($operation, &$wouldblock = null)
    {
        if (!parent::flock($operation, $wouldblock)) {
            throw FileException::lockFailed($this);
        }

        return true;
    }

    /**
     * @override
     */
    public function fputcsv(
        $fields,
        $delimiter = ',',
        $enclosure = '"',
        $escape = '\\'
    ) {
        if ('\\' === $escape) {
            $length = parent::fputcsv($fields, $delimiter, $enclosure);
        } else {
            $length = parent::fputcsv($fields, $delimiter, $enclosure, $escape);
        }

        if (false === $length) {
            throw FileException::writeFailed($this);
        }

        return $length;
    }

    /**
     * @override
     */
    public function fseek($offset, $whence = SEEK_SET)
    {
        if (-1 === parent::fseek($offset, $whence)) {
            throw FileException::seekFailed($this);
        }

        return 0;
    }

    /**
     * @override
     */
    public function ftell()
    {
        if (false === ($position = parent::ftell())) {
            throw FileException::tellFailed($this);
        }

        return $position;
    }

    /**
     * @override
     */
    public function ftruncate($size)
    {
        if (!parent::ftruncate($size)) {
            throw FileException::truncateFailed($this);
        }

        return true;
    }

    /**
     * @override
     */
    public function fwrite($str, $length = null)
    {
        if (null === $length) {
            $length = strlen($str);
        }

        if (null === ($bytes = parent::fwrite($str, $length))) {
            throw FileException::writeFailed($this);
        }

        return $bytes;
    }

    /**
     * @override
     */
    public function seek($line_pos)
    {
        try {
            parent::seek($line_pos);
        } catch (Exception $exception) {
            throw FileException::seekFailed($this, $exception);
        }
    }
}
