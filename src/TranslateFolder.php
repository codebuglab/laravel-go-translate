<?php

namespace CodeBugLab\GoTranslate;

use CodeBugLab\GoTranslate\Exceptions\WriterException;
use CodeBugLab\GoTranslate\Factory\WriterFactory;
use CodeBugLab\GoTranslate\Service\TranslateFileService;
use CodeBugLab\GoTranslate\Writer\WriterStrategyInterface;
use Symfony\Component\Console\Output\ConsoleOutput;

class TranslateFolder
{
    /**
     * @var array
     */
    public $folder;

    /**
     * @var array
     */
    public $lang;

    /**
     * @var WriterStrategyInterface
     */
    public $writer = null;

    /**
     * @var WriterFactory
     */
    public $writerFactory;

    public  function __construct(WriterFactory $writerFactory)
    {
        $this->writerFactory = $writerFactory;
    }

    public function __call($method, $args)
    {
        if (substr($method, 0, 2) === "to") {
            $extension = strtolower(substr($method, 2));

            $this->writer = $this->writerFactory->getWriter($extension);

            return $this;
        }
    }

    public function execute(): void
    {
        $this->scanFolder($this->folder['source'][0]);
    }

    private function scanFolder($folder): void
    {
        $dirList = glob($folder . '\*'); // Get all folder content (files and sub-folders)
        foreach ($dirList as $path) {
            $pathArray = explode("\\", $path);

            if (is_file($path)) {
                $filename = array_pop($pathArray);

                $extension = pathinfo($filename, PATHINFO_EXTENSION);

                if ($this->writer != null) {
                    $writer = $this->writer;
                } else {
                    try {
                        $writer = $this->writerFactory->getWriter($extension);
                    } catch (WriterException $e) {
                        $output = new ConsoleOutput();
                        $output->writeln("<error>We don't support this extension for this file " . "'{$filename}'" . "</error>");
                        continue;
                    }
                }

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

    private function translate($sourcePath, $destinationPath): void
    {
        $translateFileService = new TranslateFileService($sourcePath, $destinationPath, $this->lang);
        $translateFileService->withProgressBar();
    }
}
