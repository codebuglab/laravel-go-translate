<?php

namespace CodeBugLab\GoTranslate\Builder;

use CodeBugLab\GoTranslate\TranslateFolder;

interface TranslateFolderBuilderInterface
{
    public function setLanguage($source, $destination): self;

    public function getResult(): TranslateFolder;
}
