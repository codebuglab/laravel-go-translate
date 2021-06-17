<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Writer;

use CodeBugLab\GoTranslate\Reader\PhpReaderStrategy;
use CodeBugLab\GoTranslate\Tests\TestCase;
use CodeBugLab\GoTranslate\Writer\PhpWriterStrategy;

class PhpWriterTest extends TestCase
{
    public function test_php_writer_save_php_file()
    {
        $writer = new PhpWriterStrategy();

        $destinationFilePath = __DIR__ . "/../../Lang/reader_and_writer_test/ar/test.php";

        $array = (new PhpReaderStrategy)->reading(__DIR__ . "/../../Lang/reader_and_writer_test/en/test.php");

        $writer->writing($destinationFilePath, $array);

        $this->assertFileExists($destinationFilePath);

        unlink($destinationFilePath);
    }
}
