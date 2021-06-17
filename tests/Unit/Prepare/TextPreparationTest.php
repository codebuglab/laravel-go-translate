<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Prepare;

use CodeBugLab\GoTranslate\Prepare\TextPreparation;
use CodeBugLab\GoTranslate\Tests\TestCase;

class TextPreparationTest extends TestCase
{
    public function test_underscore_removed_from_text()
    {
        $preparation = new TextPreparation("hello_world");

        $preparation->prepareBeforeTranslate();

        $this->assertEquals("hello world", $preparation->text);
    }

    public function test_save_laravel_variables_before_translation()
    {
        $preparation = new TextPreparation("hello :name world");

        $preparation->prepareBeforeTranslate();

        $this->assertEquals("hello -1- world", $preparation->text);
    }

    public function test_save_html_entities_before_translation()
    {
        $preparation = new TextPreparation("hello &amp; world");

        $preparation->prepareBeforeTranslate();

        $this->assertEquals("hello -1- world", $preparation->text);
    }

    public function test_save_string_specifier_before_translation()
    {
        $preparation = new TextPreparation("hello %s world"); // have error

        $preparation->prepareBeforeTranslate();

        $this->assertEquals("hello -1- world", $preparation->text);
    }

    public function test_return_laravel_variables_after_translation()
    {
        $preparation = new TextPreparation("hello :name world"); // have error

        $preparation->prepareBeforeTranslate();

        $text = $preparation->prepareAfterTranslate();

        $this->assertEquals("hello :name world", $text);
    }

    public function test_return_html_entities_after_translation()
    {
        $preparation = new TextPreparation("hello &amp; world"); // have error

        $preparation->prepareBeforeTranslate();

        $text = $preparation->prepareAfterTranslate();

        $this->assertEquals("hello &amp; world", $text);
    }

    public function test_return_string_specifier_after_translation()
    {
        $preparation = new TextPreparation("hello %s world"); // have error

        $preparation->prepareBeforeTranslate();

        $text = $preparation->prepareAfterTranslate();

        $this->assertEquals("hello %s world", $text);
    }
}
