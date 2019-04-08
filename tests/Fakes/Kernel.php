<?php

namespace EagleDevelopers\NovaScheduledTasks\Tests\Fakes;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @var array
     */
    private $scheduledTasks;

    /**
     * Create a new console kernel instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @param  array $scheduledTasks
     * @return void
     */
    public function __construct(Application $app, Dispatcher $events, $scheduledTasks = [])
    {
        $this->scheduledTasks = collect($scheduledTasks);

        parent::__construct($app, $events);
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        collect($this->scheduledTasks)->each(function ($task) use ($schedule) {
            if (array_has($task, 'job')) {
                $command = $schedule->job($task['job']);
            } else {
                $command = $schedule->command($task['command']);
            }

            $command->{$task['schedule']}();

            collect(array_get($task, 'additionalOptions', []))->each(function ($additionalOption) use ($command) {
                $command->{$additionalOption}();
            });
        });
    }
}
