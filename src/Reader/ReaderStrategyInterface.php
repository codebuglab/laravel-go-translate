<?php

namespace CodeBugLab\GoTranslate\Reader;

interface ReaderStrategyInterface
{
    public function reading(string $filePath) : array;
}
