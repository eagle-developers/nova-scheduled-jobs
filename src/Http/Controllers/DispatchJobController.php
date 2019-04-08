<?php

namespace EagleDevelopers\NovaScheduledTasks\Http\Controllers;

use EagleDevelopers\NovaScheduledTasks\Rules\JobExists;
use Illuminate\Http\Request;

class DispatchJobController
{
    /**
     * Dispatch job command.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'command' => ['required', 'string', new JobExists]
        ]);

        $command = resolve($data['command']);

        dispatch($command);
    }
}
