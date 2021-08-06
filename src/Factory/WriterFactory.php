<?php

namespace CodeBugLab\GoTranslate\Factory;

use CodeBugLab\GoTranslate\Exceptions\WriterException;
use CodeBugLab\GoTranslate\Factory\WriterFactoryInterface;
use CodeBugLab\GoTranslate\Writer\JsonWriterStrategy;
use CodeBugLab\GoTranslate\Writer\PhpWriterStrategy;
use CodeBugLab\GoTranslate\Writer\WriterStrategyInterface;

class WriterFactory implements WriterFactoryInterface
{
    public function getWriter(string $extension) : WriterStrategyInterface {
        switch ($extension) {
            case "php":
                return new PhpWriterStrategy();
            case "json":
                return new JsonWriterStrategy();
            default:
                throw new WriterException();
        }
    }
}
