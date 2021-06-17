<?php

namespace CodeBugLab\GoTranslate\Service;

use CodeBugLab\GoTranslate\TranslateFile;

class TranslateFileService
{

    public $translate;

    public function __construct(
        $sourcePath,
        $destinationPath,
        $lang
    ) {
        $this->translate = new TranslateFile(
            $sourcePath,
            $destinationPath,
            $lang
        );
    }

    public function withProgressBar()
    {
        $this->translate->readFromFile();
        $this->translate->initiateProgressBar();
        $this->translate->translate();
        $this->translate->finishProgressBar();
        $this->translate->writeInFile();
    }

    public function withoutProgressBar()
    {
        $this->translate->readFromFile();
        $this->translate->translate();
        $this->translate->writeInFile();
    }
}
