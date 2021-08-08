<?php

namespace CodeBugLab\GoTranslate\Console\Commands;

use CodeBugLab\GoTranslate\Builder\TranslateFolderBuilder;
use Illuminate\Console\Command;

class GoTranslateFolder extends Command
{
    /**
     * @var string
     */
    protected $signature = 'go-translate:folder
    {sourceLang : The language of the source file}
    {destinationLang : The language of the destination file you want to save}
    {sourceFolder : The destination of the folder you want to translate}
    {destinationFolder : The source of the folder you want to save}
    {--E= : The extension you want all files to convert to}';

    /**
     * @var string
     */
    protected $description = 'translate folder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(TranslateFolderBuilder $goTranslateFolderBuilder): int
    {
        ini_set('max_execution_time', 30000000000); //300 seconds = 5 minutes

        $goTranslate = $goTranslateFolderBuilder
            ->setLanguage($this->argument('sourceLang'), $this->argument('destinationLang'))
            ->setFolder($this->argument('sourceFolder'), $this->argument('destinationFolder'))
            ->getResult();

        if ($this->option('E')) {
            $method = "to" . ucfirst($this->option('E'));
            $goTranslate->{$method}();
        }

        $goTranslate->execute();
        return 0;
    }
}
