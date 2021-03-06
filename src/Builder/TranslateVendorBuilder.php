<?php

namespace CodeBugLab\GoTranslate\Builder;

use CodeBugLab\GoTranslate\TranslateFolder;

class TranslateVendorBuilder implements TranslateFolderBuilderInterface
{
    /**
     * @var TranslateFolder
     */
    private $goTranslate;

    public function __construct(TranslateFolder $goTranslate)
    {
        $this->goTranslate = $goTranslate;
    }

    public function setLanguage($source, $destination): self
    {
        $this->goTranslate->lang = [
            "source" => $source,
            "destination" => $destination,
        ];
        return $this;
    }

    public function setFolder(): self
    {
        $this->goTranslate->folder = [
            "source" => [
                resource_path() . "\lang\\vendor"
            ],
            "destination" => [
                resource_path() . "\lang\\vendor"
            ],
        ];
        return $this;
    }

    public function getResult(): TranslateFolder
    {
        return $this->goTranslate;
    }
}
