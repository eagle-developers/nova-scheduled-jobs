<?php

namespace EagleDevelopers\NovaScheduledJobs\Http\Controllers;

use EagleDevelopers\NovaScheduledJobs\Rules\JobExist;
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
            'command' => ['required', 'string', new JobExist]
        ]);

        $command = resolve($data['command']);

        dispatch($command);
    }
}
