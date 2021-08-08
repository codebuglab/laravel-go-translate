<?php

namespace CodeBugLab\GoTranslate\Builder;

use CodeBugLab\GoTranslate\TranslateFolder;

class TranslateFolderBuilder implements TranslateFolderBuilderInterface
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

    public function setFolder($source, $destination): self
    {
        $this->goTranslate->folder = [
            "source" => [
                base_path() . "\\" . $source
            ],
            "destination" => [
                base_path() . "\\" . $destination
            ],
        ];
        return $this;
    }

    public function getResult(): TranslateFolder
    {
        return $this->goTranslate;
    }
}
