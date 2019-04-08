<?php

namespace EagleDevelopers\NovaScheduledTasks\Http\Controllers;

use EagleDevelopers\NovaScheduledTasks\Schedule\Factory as ScheduleFactory;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Console\Kernel;

class TasksController
{
    /**
     * Return a list of all scheduled tasks
     *
     * @param  Kernel   $kernel (Not sure why this is necessary, but it is.)
     * @param  Schedule $schedule
     * @return array
     */
    public function index(Kernel $kernel, Schedule $schedule)
    {
        return collect($schedule->events())
            ->map(function ($event) {
                $scheduleEvent = ScheduleFactory::make($event);

                return [
                    'command' => $scheduleEvent->command(),
                    'description' => $scheduleEvent->description(),
                    'expression' => $scheduleEvent->expression,
                    'humanReadableExpression' => $scheduleEvent->humanReadableExpression(),
                    'nextRunAt' => $scheduleEvent->nextRunAt()->toIso8601String(),
                    'timezone' => $scheduleEvent->timezone(),
                    'withoutOverlapping' => $scheduleEvent->withoutOverlapping,
                    'onOneServer' => $scheduleEvent->onOneServer,
                    'evenInMaintenanceMode' => $scheduleEvent->evenInMaintenanceMode,
                ];
            })
            ->sortBy('command')
            ->values()
            ->all();
    }
}
