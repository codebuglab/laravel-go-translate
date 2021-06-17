<?php

namespace CodeBugLab\GoTranslate\Builder;

use CodeBugLab\GoTranslate\TranslateFolder;

class TranslateResourceBuilder implements TranslateFolderBuilderInterface
{

    private $goTranslate;

    public function __construct(TranslateFolder $goTranslate)
    {
        $this->goTranslate = $goTranslate;
    }

    public function setLanguage($source, $destination)
    {
        $this->goTranslate->lang = [
            "source" => $source,
            "destination" => $destination,
        ];
        return $this;
    }
    public function setFolder()
    {
        $this->goTranslate->folder = [
            "source" => [
                resource_path() . "\lang\\" . $this->goTranslate->lang['source']
            ],
            "destination" => [
                resource_path() . "\lang\\" . $this->goTranslate->lang['destination']
            ],
        ];
        return $this;
    }

    public function getResult()
    {
        return $this->goTranslate;
    }
}
