<?php

namespace CodeBugLab\GoTranslate\Writer;

use CodeBugLab\GoTranslate\File\JsonFile;

class JsonWriterStrategy extends JsonFile implements WriterStrategyInterface
{
    public function writing(string $filePath, array $translatedFile)
    {
        file_put_contents($filePath, json_encode($translatedFile));
    }
}
