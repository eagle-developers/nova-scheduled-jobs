<?php

namespace EagleDevelopers\NovaScheduledTasks\Tests;

use Cron\CronExpression;
use EagleDevelopers\NovaScheduledTasks\Schedule\Cron;
use EagleDevelopers\NovaScheduledTasks\Tests\Fixtures\Jobs\UpdateOrders;
use EagleDevelopers\NovaScheduledTasks\Vendor\CronSchedule;
use Illuminate\Support\Carbon;

class ListTasksTest extends TestCase
{
    /** @test */
    public function itReturnsAnEmptyArrayIfThereAreNoTasksScheduled()
    {
        $response = $this->getJson('nova-vendor/eagle-developers/nova-scheduled-tasks/tasks');

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    /** @test */
    public function itReturnsAListOfScheduledTasks()
    {
        $kernel = app('EagleDevelopers\NovaScheduledTasks\Tests\Fakes\Kernel', [
            'scheduledTasks' => [
                [
                    'command' => 'cache:clear',
                    'schedule' => 'everyFiveMinutes',
                    'additionalOptions' => []
                ],
                [
                    'command' => 'store-fake-metrics',
                    'schedule' => 'hourly',
                    'additionalOptions' => [
                        'withoutOverlapping',
                        'onOneServer',
                        'evenInMaintenanceMode'
                    ]
                ],
                [
                    'job' => UpdateOrders::class,
                    'schedule' => 'daily',
                    'additionalOptions' => [
                        'evenInMaintenanceMode'
                    ]
                ],
            ],
        ]);

        app()->instance('Illuminate\Contracts\Console\Kernel', $kernel);

        $response = $this->getJson('nova-vendor/eagle-developers/nova-scheduled-tasks/tasks');

        $response->assertStatus(200);
        $response->assertJson([
            [
                'command' => 'cache:clear',
                'description' => 'Flush the application cache',
                'expression' => '*/5 * * * *',
                'humanReadableExpression' => 'Every 5 minutes every hour every day.',
                'nextRunAt' => Cron::nextRunAt('*/5 * * * *')->toIso8601String(),
                'timezone' => 'UTC',
                'withoutOverlapping' => false,
                'onOneServer' => false,
                'evenInMaintenanceMode' => false,
            ],
            [
                'command' => 'store-fake-metrics',
                'description' => '',
                'expression' => '0 * * * *',
                'humanReadableExpression' => 'On the hour every hour every day.',
                'nextRunAt' => Cron::nextRunAt('0 * * * *')->toIso8601String(),
                'timezone' => 'UTC',
                'withoutOverlapping' => true,
                'onOneServer' => true,
                'evenInMaintenanceMode' => true,
            ],
            [
                'command' => UpdateOrders::class,
                'description' => 'Fake job to update orders...',
                'expression' => '0 0 * * *',
                'humanReadableExpression' => 'At 00:00 every day.',
                'nextRunAt' => Cron::nextRunAt('0 0 * * *')->toIso8601String(),
                'timezone' => 'UTC',
                'withoutOverlapping' => false,
                'onOneServer' => false,
                'evenInMaintenanceMode' => true,
            ],
        ]);
    }
}
