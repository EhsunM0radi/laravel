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
        return $project->collaborators->contains($user) || $user->id === $project->creator;
    }
    public function destroy(User $user, Project $project)
    {
        return $user->id === $project->creator;
    }
    public function edit(User $user, Project $project)
    {
        return $project->collaborators->contains($user) || $user->id === $project->creator;
    }
    public function show(User $user, Project $project)
    {
        return $project->collaborators->contains($user) || $user->id === $project->creator;
    }
}
