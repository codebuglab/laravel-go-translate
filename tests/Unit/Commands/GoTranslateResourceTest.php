<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Command;

use CodeBugLab\GoTranslate\Console\Commands\GoTranslateResource;
use CodeBugLab\GoTranslate\Tests\TestCase;

class GoTranslateResourceTest extends TestCase
{
    private $sourceLang = "en";
    private $destinationLang = "en";

    public function test_it_has_translate_resource_command()
    {
        $this->assertTrue(
            class_exists(GoTranslateResource::class)
        );
    }

    public function test_artisan_command_work_fine()
    {
        parent::setUp();

        $this->artisan('go-translate:resource', [
            'sourceLang' => $this->sourceLang,
            'destinationLang' => $this->destinationLang
        ])->assertExitCode(0);
    }
}
