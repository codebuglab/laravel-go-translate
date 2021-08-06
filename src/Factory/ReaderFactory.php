<?php

namespace CodeBugLab\GoTranslate\Factory;

use CodeBugLab\GoTranslate\Exceptions\ReaderException;
use CodeBugLab\GoTranslate\Factory\ReaderFactoryInterface;
use CodeBugLab\GoTranslate\Reader\JsonReaderStrategy;
use CodeBugLab\GoTranslate\Reader\PhpReaderStrategy;
use CodeBugLab\GoTranslate\Reader\ReaderStrategyInterface;

class ReaderFactory implements ReaderFactoryInterface
{
    public function getReader(string $extension) : ReaderStrategyInterface {
        switch ($extension) {
            case "php":
                return new PhpReaderStrategy();
            case "json":
                return new JsonReaderStrategy();
            default:
                throw new ReaderException();
        }
    }
}
