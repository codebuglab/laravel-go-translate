<?php

namespace CodeBugLab\GoTranslate\Exceptions;

use Exception;

class WriterException extends Exception
{
    /**
     * @var string
     */
    protected $message = "We don't support this extension be sure you type acceptable one.";

    /**
     * @var int
     */
    protected $code    = 1;
}
