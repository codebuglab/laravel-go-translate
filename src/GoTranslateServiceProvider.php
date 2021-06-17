<?php

namespace CodeBugLab\GoTranslate;

use CodeBugLab\GoTranslate\Console\Commands\GoTranslateFile;
use Illuminate\Support\ServiceProvider;
use CodeBugLab\GoTranslate\Console\Commands\GoTranslateFolder;
use CodeBugLab\GoTranslate\Console\Commands\GoTranslateVendor;
use CodeBugLab\GoTranslate\Console\Commands\GoTranslateResource;

class GoTranslateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        //php artisan go-translate:folder en ar resources\\lang\\en resources\\lang\\test --E=Json
        if ($this->app->runningInConsole()) {
            $this->commands([
                GoTranslateResource::class,
                GoTranslateVendor::class,
                GoTranslateFolder::class,
                GoTranslateFile::class
            ]);
        }
    }

    public function register()
    {

    }
}
