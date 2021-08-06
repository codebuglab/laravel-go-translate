<?php

namespace CodeBugLab\GoTranslate\Factory;

interface ReaderFactoryInterface
{
    public function getReader(string $extension);
}
