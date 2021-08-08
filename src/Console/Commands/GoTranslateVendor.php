<?php

namespace CodeBugLab\GoTranslate\Console\Commands;

use CodeBugLab\GoTranslate\Builder\TranslateVendorBuilder;
use Illuminate\Console\Command;

class GoTranslateVendor extends Command
{
    /**
     * @var string
     */
    protected $signature = 'go-translate:vendor
    {sourceLang : The language of the source file}
    {destinationLang : The language of the destination file you want to save}
    {--E= : The extension you want all files to convert to}';

    /**
     * @var string
     */
    protected $description = 'translate vendor';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(TranslateVendorBuilder $goTranslateVendorBuilder): int
    {
        ini_set('max_execution_time', 30000000000); //300 seconds = 5 minutes

        $goTranslate = $goTranslateVendorBuilder
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
