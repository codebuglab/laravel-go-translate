<?php

namespace CodeBugLab\GoTranslate\Builder;

interface TranslateFolderBuilderInterface
{
    public function setLanguage($source, $destination);
    public function getResult();
}
