<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Command;

use CodeBugLab\GoTranslate\Console\Commands\GoTranslateVendor;
use CodeBugLab\GoTranslate\Tests\TestCase;

class GoTranslateVendorTest extends TestCase
{
    private $sourceLang = "en";
    private $destinationLang = "en";

    public function test_it_has_translate_vendor_command()
    {
        $this->assertTrue(
            class_exists(GoTranslateVendor::class)
        );
    }

    public function test_artisan_command_work_fine()
    {
        parent::setUp();

        $this->artisan('go-translate:vendor', [
            'sourceLang' => $this->sourceLang,
            'destinationLang' => $this->destinationLang
        ])->assertExitCode(0);
    }
}
