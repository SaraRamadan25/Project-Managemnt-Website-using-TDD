<?php

namespace App\Observers;

use App\Models\Project;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */

    //to register our observer to laravel, we will go to service provider
    public function created(Project $project)
    {
        $project->recordActivity('created');
    }

    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $project->recordActivity('updated');
    }


}
