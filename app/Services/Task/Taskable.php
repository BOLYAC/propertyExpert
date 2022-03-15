<?php

namespace App\Services\Task;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Taskable
{
    public function tasks(): MorphMany;

    public function getCreateTaskEndpoint(): string;
}
