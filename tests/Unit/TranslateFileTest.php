<?php

namespace CodeBugLab\GoTranslate\Tests\Unit;

use CodeBugLab\GoTranslate\Exceptions\ReaderException;
use CodeBugLab\GoTranslate\Exceptions\WriterException;
use CodeBugLab\GoTranslate\Tests\TestCase;
use CodeBugLab\GoTranslate\TranslateFile;

class TranslateFileTest extends TestCase
{

    private $translation;
    private $sourceExtension = ".php";
    private $destinationExtension = ".php";
    private $sourceFile = "normal_text";
    private $destinationFile = "result";
    private $sourceFolder = __DIR__ . "/../Lang/translate_file_test/en";
    private $destinationFolder = __DIR__ . "/../Lang/translate_file_test/ar";
    private $preparedResultFilePath = "/../Lang/translate_file_test/prepared_result_for_normal_text.php";
    private array $lang;

    public function setUp(): void
    {
        $this->lang = [
            "source" => "en",
            "destination" => "ar"
        ];

        $sourcePath = $this->sourceFolder . "/" . $this->sourceFile . $this->sourceExtension;

        $destinationPath = $this->destinationFolder . "/" . $this->destinationFile . $this->destinationExtension;

        $this->translation = new TranslateFile($sourcePath, $destinationPath, $this->lang);
    }

    public function test_reader_determined()
    {
        $this->assertInstanceOf("CodeBugLab\GoTranslate\Reader\PhpReaderStrategy", $this->translation->reader);
    }

    public function test_writer_determined()
    {
        $this->assertInstanceOf("CodeBugLab\GoTranslate\Writer\PhpWriterStrategy", $this->translation->writer);
    }

    public function test_source_file_determined()
    {
        $this->assertEquals($this->sourceFile, $this->translation->filename['source']);
    }

    public function test_destination_file_determined()
    {
        $this->assertEquals($this->destinationFile, $this->translation->filename['destination']);
    }

    public function test_source_folder_determined()
    {
        $this->assertEquals($this->sourceFolder, $this->translation->folder['source']);
    }

    public function test_destination_folder_determined()
    {
        $this->assertEquals($this->destinationFolder, $this->translation->folder['destination']);
    }

    public function test_language_array_is_array()
    {
        $this->translation->readFromFile();

        $this->assertIsArray($this->translation->languageArray);
    }

    public function test_translation_returned_array()
    {
        $this->translation->readFromFile();

        $this->translation->translate();

        $this->assertIsArray($this->translation->translatedFile);
    }

    public function test_translation_normal_text()
    {
        $this->translation->readFromFile();

        $this->translation->translate();

        $prepared_result = include(__DIR__ . $this->preparedResultFilePath);

        $this->assertEquals($prepared_result, $this->translation->translatedFile);
    }

    public function test_translate_empty_value_by_using_key()
    {
        $translation = new TranslateFile(
            $this->sourceFolder . "/empty_key" . $this->sourceExtension,
            $this->destinationFolder . "/" . $this->destinationFile . $this->destinationExtension,
            $this->lang
        );

        $translation->readFromFile();

        $translation->translate();

        $prepared_result = include(__DIR__ . "/../Lang/translate_file_test/prepared_result_for_empty_key.php");

        $this->assertEquals($prepared_result, $translation->translatedFile);
    }

    public function test_translate_nested_array()
    {
        $translation = new TranslateFile(
            $this->sourceFolder . "/nested_array" . $this->sourceExtension,
            $this->destinationFolder . "/" . $this->destinationFile . $this->destinationExtension,
            $this->lang
        );

        $translation->readFromFile();

        $translation->translate();

        $prepared_result = include(__DIR__ . "/../Lang/translate_file_test/prepared_result_for_nested_array.php");

        $this->assertEquals($prepared_result, $translation->translatedFile);
    }

    public function test_writer_create_folder()
    {
        $this->translation->readFromFile();

        $this->translation->translate();

        $this->translation->writeInFile();

        $this->assertDirectoryExists($this->destinationFolder);

        unlink($this->destinationFolder . "/" . $this->destinationFile . $this->destinationExtension);

        rmdir($this->destinationFolder);
    }

    public function test_writer_save_file_in_destination_folder()
    {
        $this->translation->readFromFile();

        $this->translation->translate();

        $this->translation->writeInFile();

        $this->assertFileExists($this->destinationFolder . "/" . $this->destinationFile . $this->destinationExtension);

        unlink($this->destinationFolder . "/" . $this->destinationFile . $this->destinationExtension);

        rmdir($this->destinationFolder);
    }

    public function test_reader_throw_an_exception_for_unsupported_extensions()
    {

        $this->expectException(ReaderException::class);

        $this->lang = [
            "source" => "en",
            "destination" => "ar"
        ];

        $sourcePath = $this->sourceFolder . "/not_supported_extension.xml";

        $destinationPath = $this->destinationFolder . "/not_supported_extension.xml";

        $this->translation = new TranslateFile($sourcePath, $destinationPath, $this->lang);
    }

    public function test_writer_throw_an_exception_for_unsupported_extensions()
    {

        $this->expectException(WriterException::class);

        $this->lang = [
            "source" => "en",
            "destination" => "ar"
        ];

        $sourcePath = $this->sourceFolder . "/normal_text.php";

        $destinationPath = $this->destinationFolder . "/not_supported_extension.xml";

        $this->translation = new TranslateFile($sourcePath, $destinationPath, $this->lang);
    }
}
