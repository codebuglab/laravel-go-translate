<?php

namespace CodeBugLab\GoTranslate\Factory;

use CodeBugLab\GoTranslate\Writer\WriterStrategyInterface;

interface WriterFactoryInterface
{
    public function getWriter(string $extension) : WriterStrategyInterface;
}
