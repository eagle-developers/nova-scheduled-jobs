<?php

namespace EagleDevelopers\NovaScheduledTasks\Tests;

use Cron\CronExpression;
use EagleDevelopers\NovaScheduledTasks\Schedule\Cron;
use EagleDevelopers\NovaScheduledTasks\Tests\Fixtures\Jobs\UpdateOrders;
use EagleDevelopers\NovaScheduledTasks\Tests\Fixtures\Jobs\UpdateOrdersWithDependencies;
use EagleDevelopers\NovaScheduledTasks\Vendor\CronSchedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;

class DispatchJobTest extends TestCase
{
    /** @test */
    public function canDispatchJob()
    {
        Bus::fake();

        $this->postJson('nova-vendor/eagle-developers/nova-scheduled-tasks/dispatch-job', [
            'command' => UpdateOrders::class,
        ])->assertStatus(200);

        Bus::assertDispatched(UpdateOrders::class);
    }

    /** @test */
    public function canDispatchJobWithDependencies()
    {
        Bus::fake();

        $this->postJson('nova-vendor/eagle-developers/nova-scheduled-tasks/dispatch-job', [
            'command' => UpdateOrdersWithDependencies::class,
        ])->assertStatus(200);

        Bus::assertDispatched(UpdateOrdersWithDependencies::class);
    }
}
