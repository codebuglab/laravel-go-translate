<?php

namespace CodeBugLab\GoTranslate\Writer;

interface WriterStrategyInterface
{
    public function writing(string $filePath, array $translatedFile);
}
