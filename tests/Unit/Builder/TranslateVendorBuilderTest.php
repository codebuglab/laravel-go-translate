<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Builder;

use CodeBugLab\GoTranslate\Builder\TranslateVendorBuilder;
use CodeBugLab\GoTranslate\Factory\WriterFactory;
use CodeBugLab\GoTranslate\Tests\TestCase;
use CodeBugLab\GoTranslate\TranslateFolder;

class TranslateVendorBuilderTest extends TestCase
{
    private $sourceLang = "en";
    private $destinationLang = "en";

    public function test_translate_vendor_builder_build_an_object()
    {
        $goTranslate = (new TranslateVendorBuilder(
            new TranslateFolder(
                new WriterFactory()
            )
        ))->getResult();

        $this->assertInstanceOf(TranslateFolder::class, $goTranslate);
    }

    public function test_translate_vendor_builder_is_set_languages()
    {
        $goTranslate = (new TranslateVendorBuilder(
            new TranslateFolder(
                new WriterFactory()
            )
        ))->setLanguage($this->sourceLang, $this->destinationLang)
            ->getResult();

        $this->assertEquals(
            [
                'source' => $this->sourceLang,
                'destination' => $this->destinationLang
            ],
            $goTranslate->lang
        );
    }

    public function test_translate_vendor_builder_is_set_folder()
    {
        $goTranslate = (new TranslateVendorBuilder(
            new TranslateFolder(
                new WriterFactory()
            )
        ))->setLanguage($this->sourceLang, $this->destinationLang)
            ->setFolder()
            ->getResult();

        $this->assertEquals(
            [
                'source' => [resource_path() . "\lang\\vendor"],
                'destination' => [resource_path() . "\lang\\vendor"]
            ],
            $goTranslate->folder
        );
    }
}
