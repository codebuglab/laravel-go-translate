<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Builder;

use CodeBugLab\GoTranslate\Builder\TranslateFolderBuilder;
use CodeBugLab\GoTranslate\Tests\TestCase;
use CodeBugLab\GoTranslate\TranslateFolder;

class TranslateFolderBuilderTest extends TestCase
{
    private $sourceLang = "en";
    private $destinationLang = "en";
    private $sourceFolder = "../../../../tests/Lang/builder_test";
    private $destinationFolder = "../../../../tests/Lang/builder_test";

    public function test_translate_folder_builder_build_an_object()
    {
        $goTranslate = (new TranslateFolderBuilder(new TranslateFolder()))
            ->getResult();

        $this->assertInstanceOf(TranslateFolder::class, $goTranslate);
    }

    public function test_translate_folder_builder_is_set_languages()
    {
        $goTranslate = (new TranslateFolderBuilder(new TranslateFolder()))
            ->setLanguage($this->sourceLang, $this->destinationLang)
            ->getResult();

        $this->assertEquals(
            [
                'source' => $this->sourceLang,
                'destination' => $this->destinationLang
            ],
            $goTranslate->lang
        );
    }

    public function test_translate_folder_builder_is_set_folders()
    {
        $goTranslate = (new TranslateFolderBuilder(new TranslateFolder()))
            ->setFolder($this->sourceFolder, $this->destinationFolder)
            ->getResult();

        $this->assertEquals(
            [
                'source' => [base_path() . "\\" . $this->sourceFolder],
                'destination' => [base_path() . "\\" . $this->destinationFolder]
            ],
            $goTranslate->folder
        );
    }
}
