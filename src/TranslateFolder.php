<?php

namespace CodeBugLab\GoTranslate;

use CodeBugLab\GoTranslate\Helper\WriterHelper;
use CodeBugLab\GoTranslate\Service\TranslateFileService;

class TranslateFolder
{
    public  $folder;
    public  $lang;
    public  $writer = null;


    public  function __construct()
    {
    }

    public function __call($method, $args)
    {
        if (substr($method, 0, 2) === "to") {
            $extension = strtolower(substr($method, 2));

            $this->writer = WriterHelper::getWriter($extension);

            return $this;
        }
    }

    public function execute()
    {
        $this->scanFolder($this->folder['source'][0]);
    }

    private function scanFolder($folder)
    {
        $dirList = glob($folder . '\*');
        foreach ($dirList as $path) {
            $pathArray = explode("\\", $path);

            if (is_file($path)) {
                $filename = array_pop($pathArray);

                $extension = pathinfo($filename, PATHINFO_EXTENSION);

                $writer = ($this->writer != null) ? $this->writer : WriterHelper::getWriter($extension);

                $fileDestinationPath = sprintf(
                    "%s\\%s%s",
                    end($this->folder['destination']),
                    explode(".", $filename)[0],
                    $writer->extension
                );

                if (file_exists($fileDestinationPath)) {
                    continue;
                }

                $sourcePath = end($this->folder['source']) . "/" . $filename;

                $destinationPath = end($this->folder['destination']) . "/" . pathinfo($filename, PATHINFO_FILENAME) . $writer->extension;

                $this->translate($sourcePath, $destinationPath);
            } else {
                $newSourceFolder = end($pathArray);
                $newDestinationFolder = ($newSourceFolder != $this->lang['source']) ? $newSourceFolder : $this->lang['destination'];
                $this->folder['source'][] = end($this->folder['source']) . "\\" . $newSourceFolder;
                $this->folder['destination'][] = end($this->folder['destination']) . "\\" . $newDestinationFolder;
                $this->scanFolder(end($this->folder['source']));
            }
        }

        array_pop($this->folder['source']);
        array_pop($this->folder['destination']);
    }

    private function translate($sourcePath, $destinationPath)
    {
        $translateFileService = new TranslateFileService($sourcePath, $destinationPath, $this->lang);
        $translateFileService->withProgressBar();
    }
}
