<?php

namespace EagleDevelopers\NovaScheduledJobs\Tests;

use EagleDevelopers\NovaScheduledJobs\NovaScheduledJobsServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp()
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);

        $this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [
            NovaScheduledJobsServiceProvider::class,
        ];
    }
}
