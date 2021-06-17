<?php

namespace CodeBugLab\GoTranslate\Reader;

use CodeBugLab\GoTranslate\File\JsonFile;

class JsonReaderStrategy extends JsonFile implements ReaderStrategyInterface
{
    public function reading(string $filePath) : array
    {
        return json_decode(file_get_contents($filePath), true);
    }
}
