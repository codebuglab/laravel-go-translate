<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Reader;

use CodeBugLab\GoTranslate\Reader\JsonReaderStrategy;
use CodeBugLab\GoTranslate\Tests\TestCase;

class JsonReaderTest extends TestCase
{
    public function test_json_reader_read_json_file()
    {
        $reader = new JsonReaderStrategy();

        $result = $reader->reading(__DIR__ . "/../../Lang/reader_and_writer_test/en/test.json");

        $this->assertIsArray($result);
    }
}
