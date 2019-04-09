<?php

namespace EagleDevelopers\NovaScheduledTasks\Tests;

use EagleDevelopers\NovaScheduledTasks\ToolServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp() : void
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);

        $this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [
            ToolServiceProvider::class,
        ];
    }
}
