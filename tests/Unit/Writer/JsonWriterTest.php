<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Writer;

use CodeBugLab\GoTranslate\Reader\JsonReaderStrategy;
use CodeBugLab\GoTranslate\Tests\TestCase;
use CodeBugLab\GoTranslate\Writer\JsonWriterStrategy;

class JsonWriterTest extends TestCase
{
    public function test_json_writer_save_json_file()
    {
        $writer = new JsonWriterStrategy();

        $destinationFilePath = __DIR__ . "/../../Lang/reader_and_writer_test/ar/test.json";

        $array = (new JsonReaderStrategy)->reading(__DIR__ . "/../../Lang/reader_and_writer_test/en/test.json");

        $writer->writing($destinationFilePath, $array);

        $this->assertFileExists($destinationFilePath);

        unlink($destinationFilePath);
    }
}
