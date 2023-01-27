<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    //instead of boot function in the class

    public function created(Task $task)
    {
        $task->project->recordActivity('created_task');
    }


    public function deleted(Task $task)
    {
        $task->project->recordActivity('deleted_task');
    }
}
