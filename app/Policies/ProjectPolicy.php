<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function view(?User $user, Project $project): bool
    {
        return !($project->for_registered == 1 && $user == null);
    }
}
