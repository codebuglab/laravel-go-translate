<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Command;

use CodeBugLab\GoTranslate\Console\Commands\GoTranslateFolder;
use CodeBugLab\GoTranslate\Exceptions\WriterException;
use CodeBugLab\GoTranslate\Tests\TestCase;

class GoTranslateFolderTest extends TestCase
{
    private $filename = "test";
    private $fileExtension = ".php";
    private $sourceLang = "en";
    private $destinationLang = "ar";
    private $sourceFolder = "../../../../tests/Lang/command_test/normal_folder";
    private $destinationFolder = "../../../../tests/Lang/command_test/normal_folder";
    private $sourceNestedFolder = "../../../../tests/Lang/command_test/nested_folder";
    private $destinationNestedFolder = "../../../../tests/Lang/command_test/nested_folder";

    public function test_it_has_translate_folder_command()
    {
        $this->assertTrue(
            class_exists(GoTranslateFolder::class)
        );
    }

    public function test_artisan_command_work_fine()
    {
        $this->artisan('go-translate:folder', [
            'sourceLang' => $this->sourceLang,
            'destinationLang' => $this->destinationLang,
            'sourceFolder' => $this->sourceFolder . "/" . $this->sourceLang,
            'destinationFolder' => $this->destinationFolder . "/" . $this->destinationLang
        ]);

        $this->assertFileExists(__DIR__ . "/../../Lang/command_test/normal_folder/ar/" . $this->filename . $this->fileExtension);

        unlink(__DIR__ . "/../../Lang/command_test/normal_folder/ar/" . $this->filename . $this->fileExtension);

        rmdir(__DIR__ . "/../../Lang/command_test/normal_folder/ar");
    }

    public function test_artisan_command_can_translate_file_in_nested_folders()
    {
        $this->artisan('go-translate:folder', [
            'sourceLang' => $this->sourceLang,
            'destinationLang' => $this->destinationLang,
            'sourceFolder' => $this->sourceNestedFolder . "/" . $this->sourceLang,
            'destinationFolder' => $this->destinationNestedFolder . "/" . $this->destinationLang
        ]);

        $this->assertFileExists(__DIR__ . "/../../Lang/command_test/nested_folder/ar/level_one/level_two/" . $this->filename . $this->fileExtension);

        unlink(__DIR__ . "/../../Lang/command_test/nested_folder/ar/level_one/level_two/" . $this->filename . $this->fileExtension);

        $this->removeNestedFolders();
    }

    public function test_artisan_command_can_translate_file_and_safe_it_in_another_format()
    {
        $this->artisan('go-translate:folder', [
            'sourceLang' => $this->sourceLang,
            'destinationLang' => $this->destinationLang,
            'sourceFolder' => $this->sourceFolder . "/" . $this->sourceLang,
            'destinationFolder' => $this->sourceFolder . "/" . $this->destinationLang,
            '--E' => "json"
        ]);

        $this->assertFileExists(__DIR__ . "/../../Lang/command_test/normal_folder/ar/" . $this->filename . ".json");

        unlink(__DIR__ . "/../../Lang/command_test/normal_folder/ar/" . $this->filename . ".json");

        $this->removeNestedFolders();
    }

    public function test_artisan_command_throw_an_error_for_unsupported_extensions()
    {
        $this->expectException(WriterException::class);

        $this->artisan('go-translate:folder', [
            'sourceLang' => $this->sourceLang,
            'destinationLang' => $this->destinationLang,
            'sourceFolder' => $this->sourceFolder . "/" . $this->sourceLang,
            'destinationFolder' => $this->sourceFolder . "/" . $this->destinationLang,
            '--E' => "xml"
        ]);
    }

    private function removeNestedFolders()
    {
        rmdir(__DIR__ . "/../../Lang/command_test/nested_folder/ar/level_one/level_two");
        rmdir(__DIR__ . "/../../Lang/command_test/nested_folder/ar/level_one");
        rmdir(__DIR__ . "/../../Lang/command_test/normal_folder/ar");
    }
}
