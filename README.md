File
====

[![SensioLabsInsight][]](https://insight.sensiolabs.com/projects/cd51bc0a-cb5c-41df-b500-9be18b98fd5d)
[![Build Status][]](https://travis-ci.org/kherge-abandoned/php-file)
[![Latest Stable Version][]](https://packagist.org/packages/kherge/file)
[![Latest Unstable Version][]](https://packagist.org/packages/kherge/file)
[![Total Downloads][]](https://packagist.org/packages/kherge/file)

An extension of `SplFileObject` that uses exceptions.

Usage
-----

You would use this class the exact same way you use `SplFileObject`, because
it is `SplFileObject`. The only difference is that errors will throw an
exception when they occur.

```php
use KHerGe\File\File;

$file = new File('example.txt');
$file->fseek(-1);

/* 
 * Fatal error: Uncaught exception 'KHerGe\File\Exception\FileException' with message 'The file "test.txt" could not be seeked.' in /path/to/file/src/lib/KHerGe/File/Exception/FileException.php on line 157
 *
 * KHerGe\File\Exception\FileException: The file "test.txt" could not be seeked. in /path/to/file/src/lib/KHerGe/File/Exception/FileException.php on line 157
 *
 * Call Stack:
 *     0.0001     248992   1. {main}() /path/to/file/test.php:0
 *     0.0011     382928   2. KHerGe\File\File->fseek() /path/to/file/test.php:6
 */
```

> Exceptions originally thrown by `SplFileObject` will also be wrapped in the
> `FileException` class included with this library.

Requirements
------------

- PHP >= 5.4

Installation
------------

Via [Composer][]:

    $ composer require "kherge/file=dev-master"

> I recommend that you install the most recent stable release. You can find one
> on Packagist, the GitHub releases page, or the tag list in the Git repository.

License
-------

This library is available under the [MIT license](LICENSE).

[SensioLabsInsight]: https://insight.sensiolabs.com/projects/cd51bc0a-cb5c-41df-b500-9be18b98fd5d/mini.png
[Build Status]: https://travis-ci.org/kherge-abandoned/php-file.png?branch=master
[Latest Stable Version]: https://poser.pugx.org/kherge/file/v/stable.png
[Latest Unstable Version]: https://poser.pugx.org/kherge/file/v/unstable.png
[Total Downloads]: https://poser.pugx.org/kherge/file/downloads.png

[Composer]: http://getcomposer.org/
