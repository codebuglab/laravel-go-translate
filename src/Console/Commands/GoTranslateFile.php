<?php

namespace CodeBugLab\GoTranslate\Console\Commands;

use CodeBugLab\GoTranslate\Service\TranslateFileService;
use Illuminate\Console\Command;

class GoTranslateFile extends Command
{
    /**
     * @var string
     */
    protected $signature = 'go-translate:file
    {sourceLang : The language of the source file}
    {destinationLang : The language of the destination file you want to save}
    {sourcePath : The full path of the source file}
    {destinationPath : The full path of the destination file}
    {--E= : The extension you want all files to convert to}';

    /**
     * @var string
     */
    protected $description = 'translate resource';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        ini_set('max_execution_time', 30000000000); //300 seconds = 5 minutes

        $sourcePath = $this->argument('sourcePath');
        $destinationPath = $this->argument('destinationPath');
        $lang['source'] = $this->argument('sourceLang');
        $lang['destination'] = $this->argument('destinationLang');

        $translateFileService = new TranslateFileService($sourcePath, $destinationPath, $lang);
        $translateFileService->withProgressBar();
        return 0;
    }
}
