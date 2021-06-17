<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Reader;

use CodeBugLab\GoTranslate\Helper\WriterHelper;
use CodeBugLab\GoTranslate\Tests\TestCase;

class WriterHelperTest extends TestCase
{

    public function test_writer_helper_return_php_writer_strategy_object()
    {
        $writer = WriterHelper::getWriter("php");

        $this->assertInstanceOf("CodeBugLab\GoTranslate\Writer\PhpWriterStrategy", $writer);
    }

    public function test_writer_helper_return_json_writer_strategy_object()
    {
        $writer = WriterHelper::getWriter("json");

        $this->assertInstanceOf("CodeBugLab\GoTranslate\Writer\JsonWriterStrategy", $writer);
    }
}
