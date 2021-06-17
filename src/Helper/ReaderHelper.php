<?php

namespace CodeBugLab\GoTranslate\Helper;

use CodeBugLab\GoTranslate\Exceptions\ReaderException;
use CodeBugLab\GoTranslate\Reader\JsonReaderStrategy;
use CodeBugLab\GoTranslate\Reader\PhpReaderStrategy;

class ReaderHelper
{
    public static function getReader($extension) {
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
