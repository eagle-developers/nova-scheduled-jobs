<?php

namespace EagleDevelopers\NovaScheduledJobs\Tests;

use Cron\CronExpression;
use EagleDevelopers\NovaScheduledJobs\Schedule\Cron;
use EagleDevelopers\NovaScheduledJobs\Tests\Fixtures\Jobs\UpdateOrders;
use EagleDevelopers\NovaScheduledJobs\Tests\Fixtures\Jobs\UpdateOrdersWithDependencies;
use EagleDevelopers\NovaScheduledJobs\Vendor\CronSchedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;

class DispatchJobTest extends TestCase
{
    /** @test */
    public function canDispatchJob()
    {
        Bus::fake();

        $this->postJson('nova-vendor/eagle-developers/nova-scheduled-jobs/dispatch-job', [
            'command' => UpdateOrders::class,
        ])->assertStatus(200);

        Bus::assertDispatched(UpdateOrders::class);
    }

    /** @test */
    public function canDispatchJobWithDependencies()
    {
        Bus::fake();

        $this->postJson('nova-vendor/eagle-developers/nova-scheduled-jobs/dispatch-job', [
            'command' => UpdateOrdersWithDependencies::class,
        ])->assertStatus(200);

        Bus::assertDispatched(UpdateOrdersWithDependencies::class);
    }
}
