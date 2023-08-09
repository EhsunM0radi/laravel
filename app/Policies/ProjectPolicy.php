<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, Project $project)
    {
        return $user->id === $project->creator;
    }
    public function destroy(User $user, Project $project)
    {
        return $user->id === $project->creator;
    }
}
