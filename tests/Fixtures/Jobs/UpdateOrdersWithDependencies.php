<?php

namespace EagleDevelopers\NovaScheduledJobs\Tests\Fixtures\Jobs;

use EagleDevelopers\NovaScheduledJobs\Tests\Fixtures\Processors\FakeOrderProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateOrdersWithDependencies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /*
     * Optional Description that would be displayed for package, not necessary to run job
     */
    public $description = 'Fake job to update orders...';

    private $processor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FakeOrderProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // some fake logic goes here...
    }
}
