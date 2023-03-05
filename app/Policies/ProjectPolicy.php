<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user may update the project.
     *
     * @param  User    $user
     * @param  Project $project
     * @return bool
     */
    public function update(User $user, Project $project): bool
    {
        // either of them when true the project will be normally updated
        return $user->is($project->owner) || $project->members->contains($user);

    }
}
