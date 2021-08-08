<?php

namespace CodeBugLab\GoTranslate\Console\Commands;

use CodeBugLab\GoTranslate\Builder\TranslateResourceBuilder;
use Illuminate\Console\Command;

class GoTranslateResource extends Command
{
    /**
     * @var string
     */
    protected $signature = 'go-translate:resource
    {sourceLang : The language of the source file}
    {destinationLang : The language of the destination file you want to save}
    {--E= : The extension you want all files to convert to}';

    /**
     * @var string
     */
    protected $description = 'translate resource';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(TranslateResourceBuilder $goTranslateResourceBuilder): int
    {
        ini_set('max_execution_time', 30000000000); //300 seconds = 5 minutes

        $goTranslate = $goTranslateResourceBuilder
            ->setLanguage($this->argument('sourceLang'), $this->argument('destinationLang'))
            ->setFolder()
            ->getResult();

        if ($this->option('E')) {
            $method = "to" . ucfirst($this->option('E'));
            $goTranslate->{$method}();
        }

        $goTranslate->execute();
        return 0;
    }
}
