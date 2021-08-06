<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Reader;

use CodeBugLab\GoTranslate\Factory\ReaderFactory;
use CodeBugLab\GoTranslate\Tests\TestCase;

class ReaderHelperTest extends TestCase
{

    public function test_reader_helper_return_php_reader_strategy_object()
    {
        $reader = (new ReaderFactory())->getReader("php");

        $this->assertInstanceOf("CodeBugLab\GoTranslate\Reader\PhpReaderStrategy", $reader);
    }

    public function test_reader_helper_return_json_reader_strategy_object()
    {
        $reader = (new ReaderFactory())->getReader("json");

        $this->assertInstanceOf("CodeBugLab\GoTranslate\Reader\JsonReaderStrategy", $reader);
    }
}
