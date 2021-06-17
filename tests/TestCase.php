<?php

namespace CodeBugLab\GoTranslate\Tests;

use CodeBugLab\GoTranslate\GoTranslateServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    protected function getPackageProviders($app): array
    {
        return [
            GoTranslateServiceProvider::class,
        ];
    }

}
