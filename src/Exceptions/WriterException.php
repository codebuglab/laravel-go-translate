<?php

namespace CodeBugLab\GoTranslate\Exceptions;

use Exception;

class WriterException extends Exception
{
    protected $message = "We don't support this extension be sure you type acceptable one.";
    protected $code    = 1;
}
