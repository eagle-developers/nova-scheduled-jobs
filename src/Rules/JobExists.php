<?php

namespace EagleDevelopers\NovaScheduledTasks\Rules;

use Illuminate\Contracts\Validation\Rule;

class JobExists implements Rule
{
    public function passes($attribute, $value)
    {
        return class_exists($value) && strpos($value, '\Jobs') !== false;
    }

    public function message()
    {
        return 'The given value must be a valid job.';
    }
}
