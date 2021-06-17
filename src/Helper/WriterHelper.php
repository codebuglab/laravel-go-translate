<?php

namespace CodeBugLab\GoTranslate\Helper;

use CodeBugLab\GoTranslate\Exceptions\WriterException;
use CodeBugLab\GoTranslate\Writer\JsonWriterStrategy;
use CodeBugLab\GoTranslate\Writer\PhpWriterStrategy;

class WriterHelper
{
    public static function getWriter($extension)
    {
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
