<?php

namespace CodeBugLab\GoTranslate\Tests\Unit\Builder;

use CodeBugLab\GoTranslate\Builder\TranslateResourceBuilder;
use CodeBugLab\GoTranslate\Tests\TestCase;
use CodeBugLab\GoTranslate\TranslateFolder;

class TranslateResourceBuilderTest extends TestCase
{
    private $sourceLang = "en";
    private $destinationLang = "en";

    public function test_translate_resource_builder_build_an_object()
    {
        $goTranslate = (new TranslateResourceBuilder(new TranslateFolder()))
            ->getResult();

        $this->assertInstanceOf(TranslateFolder::class, $goTranslate);
    }

    public function test_translate_resource_builder_is_set_languages()
    {
        $goTranslate = (new TranslateResourceBuilder(new TranslateFolder()))
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

    public function test_translate_resource_builder_is_set_folder()
    {
        $goTranslate = (new TranslateResourceBuilder(new TranslateFolder()))
            ->setLanguage($this->sourceLang, $this->destinationLang)
            ->setFolder()
            ->getResult();

        $this->assertEquals(
            [
                'source' => [resource_path() . "\lang\\" . $this->sourceLang],
                'destination' => [resource_path() . "\lang\\" . $this->destinationLang]
            ],
            $goTranslate->folder
        );
    }
}
