<?php

namespace CodeBugLab\GoTranslate\Factory;

use CodeBugLab\GoTranslate\Reader\ReaderStrategyInterface;

interface ReaderFactoryInterface
{
    public function getReader(string $extension): ReaderStrategyInterface;
}
