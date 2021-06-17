<?php

namespace CodeBugLab\GoTranslate\Reader;

use CodeBugLab\GoTranslate\File\PhpFile;

class PhpReaderStrategy extends PhpFile implements ReaderStrategyInterface
{

    public function reading(string $filePath) : array
    {
        return require($filePath);
    }
}
