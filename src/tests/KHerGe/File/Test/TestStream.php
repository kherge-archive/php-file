<?php

namespace KHerGe\File\Test;

/**
 * A test stream wrapper.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class TestStream
{
    /**
     * The desired EOF result.
     *
     * @var boolean
     */
    public static $eof = false;

    /**
     * Returns the desired EOF value.
     */
    public function stream_eof()
    {
        return self::$eof;
    }

    /**
     * Falsifies a successful stream open.
     */
    public function stream_open()
    {
        return true;
    }

    /**
     * Forces an error on read.
     */
    public function stream_read()
    {
        return false;
    }

    /**
     * Forces an error on tell.
     */
    public function stream_tell()
    {
        return false;
    }

    /**
     * Forces an error on write.
     */
    public function stream_write()
    {
        return 0;
    }

    /**
     * Intentionally fails stat.
     */
    public function url_stat()
    {
    }
}
