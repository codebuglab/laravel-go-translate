<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Reader;

use CodeBugLab\GoTranslate\Reader\PhpReaderStrategy;
use CodeBugLab\GoTranslate\Tests\TestCase;

class PhpReaderTest extends TestCase
{
    public function test_php_reader_read_php_file()
    {
        $reader = new PhpReaderStrategy();

        $result = $reader->reading(__DIR__ . "/../../Lang/reader_and_writer_test/en/test.php");

        $this->assertIsArray($result);
    }
}
