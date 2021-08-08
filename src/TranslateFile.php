<?php

namespace CodeBugLab\GoTranslate;

use CodeBugLab\GoTranslate\Factory\ReaderFactory;
use CodeBugLab\GoTranslate\Factory\WriterFactory;
use Dejurin\GoogleTranslateForFree;
use CodeBugLab\GoTranslate\File\FileInterface;
use CodeBugLab\GoTranslate\Prepare\TextPreparation;
use CodeBugLab\GoTranslate\Reader\ReaderStrategyInterface;
use CodeBugLab\GoTranslate\Writer\WriterStrategyInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class TranslateFile
{
    /**
     * @var array
     */
    public $filename;

    /**
     * @var ReaderStrategyInterface
     */
    public $reader;

    /**
     * @var WriterStrategyInterface
     */
    public $writer;

    /**
     * @var array
     */
    public $folder;

    /**
     * @var array
     */
    public $lang;

    /**
     * @var string
     */
    public $attempts;

    /**
     * @var array
     */
    public $languageArray;

    /**
     * @var array
     */
    public $translatedFile;

    /**
     * @var GoogleTranslateForFree
     */
    public $translateForFree;

    /**
     * @var TextPreparation
     */
    public $preparation;

    private $progressBar = null;

    public function __construct(
        string $sourcePath,
        string $destinationPath,
        array $lang,
        int $attempts = 1
    ) {
        $this->filename['source'] = pathinfo($sourcePath, PATHINFO_FILENAME);
        $this->filename['destination'] = pathinfo($destinationPath, PATHINFO_FILENAME);
        $this->reader = (new ReaderFactory())->getReader(pathinfo($sourcePath, PATHINFO_EXTENSION));
        $this->writer = (new WriterFactory())->getWriter(pathinfo($destinationPath, PATHINFO_EXTENSION));
        $this->folder['source'] = pathinfo($sourcePath, PATHINFO_DIRNAME);
        $this->folder['destination'] = pathinfo($destinationPath, PATHINFO_DIRNAME);;
        $this->lang = $lang;
        $this->attempts = $attempts;
        $this->translateForFree = new GoogleTranslateForFree();
    }

    /**
     * Reading from lang file to translate it.
     */
    public function readFromFile(): void
    {
        $filePath = $this->filePath("source", $this->reader);
        $this->languageArray = $this->reader->reading($filePath);
    }

    /**
     * Initiate progress bar and determine how many rows in the language array
     */
    public function initiateProgressBar(): void
    {
        if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        }
        $countOfRows = array_sum(array_map("count", $this->languageArray));

        $output = new ConsoleOutput();
        $this->progressBar = new ProgressBar($output, $countOfRows);
        $this->progressBar->setBarCharacter('<fg=green>⚬</>');
        $this->progressBar->setProgressCharacter('<fg=green>➤</>');
        $this->progressBar->setEmptyBarCharacter("<fg=red>⚬</>");
        $this->progressBar->setMessage("<fg=white;bg=blue>Loading....</>", 'status');
        $this->progressBar->setFormat("<fg=white;bg=blue>Creating file: {$this->folder['destination']}\\{$this->filename['destination']}{$this->writer->extension}</>\n%current%/%max% [%bar%] %percent:3s%%\n %estimated:-20s%  %memory:20s%\n%status%\n");
        $this->progressBar->setBarWidth(50);
        $this->progressBar->start();
    }

    /**
     * Translate function to start translate which call recursion function
     */
    public function translate(): void
    {
        $this->translatedFile = $this->translateArray([], $this->languageArray);
    }

    /**
     * Finish the progress bar
     */
    public function finishProgressBar(): void
    {
        $this->progressBar->setMessage("<fg=white;bg=green>Translation complete and all files have saved</>", 'status');
        $this->progressBar->finish();
    }

    /**
     * Check if folder exist or not and create it if it is not
     * Then writing in new lang file after translate
     */
    public function writeInFile(): void
    {
        if (!is_dir($this->folder['destination'])) {
            mkdir($this->folder['destination'], 0777, true);
        }

        $filePath = $this->filePath("destination", $this->writer);
        $this->writer->writing($filePath, $this->translatedFile);
    }

    /**
     * Translate array which is recursion function
     */
    private function translateArray(array $newFile, array $array): array
    {
        foreach ($array as $textKey => $text) {
            if (is_array($text)) {
                $newFile[$textKey] = $this->translateArray([], $text);
            } else {
                $myText = (!empty($text)) ? $text : $textKey;
                $this->preparation = new TextPreparation($myText);
                $this->preparation->prepareBeforeTranslate();
                $this->translateByGoogle();
                $newFile[$textKey] = $this->preparation->prepareAfterTranslate();

                if ($this->progressBar instanceof ProgressBar) {
                    $this->progressBar->advance();
                    if (!empty($this->preparation->text)) {
                        $this->progressBar->setMessage("<fg=white;bg=green>Translation success</>", 'status');
                    } else {
                        $this->progressBar->setMessage("<fg=white;bg=red>Translation error</>", 'status');
                    }
                }
            }

            sleep(1);
        }

        return $newFile;
    }

    /**
     * Translation using GoogleTranslateForFree package
     */
    private function translateByGoogle(): void
    {
        $this->preparation->text = $this->translateForFree->translate(
            $this->lang['source'],
            $this->lang['destination'],
            $this->preparation->text,
            $this->attempts
        );
    }

    /**
     * Determine and return file path
     */
    private function filePath(string $path, FileInterface $file): string
    {
        return sprintf("%s/%s%s", $this->folder[$path], $this->filename[$path], $file->extension);
    }
}
