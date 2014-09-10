<?php

namespace KHerGe\File;

/**
 * Manages errors for read and write operations for a new temporary file.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class TempFile extends File
{
    /**
     * Creates a new temporary file.
     *
     * The new file object is created using the "php://temp" stream. If the
     * memory limit specified is exceeded, it will automatically switch to
     * using a file-based stream instead of a memory one.
     *
     * @param integer $memory The maximum amount of memory in bytes. (default: 2MB)
     * @param string  $mode   The file open mode. (default: w+)
     */
    public function __construct($memory = 2097152, $mode = 'w+')
    {
        parent::__construct("php://temp/maxmemory:$memory", $mode);
    }
}
