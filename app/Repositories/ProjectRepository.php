<?php

namespace App\Repositories;

use App\Filters\ProjectFilter;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ProjectRepository
{
    private ProjectService $service;

    public function __construct(ProjectService $projectService)
    {
        $this->service = $projectService;
    }

    public function projectsPaginated(ProjectFilter $filters, int $paginate = 24): LengthAwarePaginator
    {
        return Project::filter($filters)->when(!Auth::check(), fn ($query) => $query->where('for_registered', 0))
            ->paginate($paginate);
    }

    public function store(ProjectRequest $request): false|Project
    {
        $project = new Project($request->validated());
        $image = $request->file('image');
        $technologies = $request->input('technologies');

        if ($request->hasFile('image') && !is_null($image) && !is_array($image)) {
            $project->image_path = $this->service->storeImage($image);
        }

        $isSave = $project->save();
        $project->technologies()->attach($technologies);

        return ($isSave) ? $project : false;
    }

    public function update(ProjectRequest $request, Project $project): bool
    {
        $image = $request->file('image');
        $technologies = $request->input('technologies');

        if ($request->hasAny(['delete_image', 'image']) && !is_null($project->image_path)) {
            $this->service->deleteImage($project->image_path);
            $project->image_path = null;
        }

        if ($request->hasFile('image') && !is_null($image) && !is_array($image)) {
            $project->image_path = $this->service->storeImage($image);
        }

        if (is_array($technologies)) {
            $project->technologies()->sync($technologies);
        }

        return $project->update($request->validated());
    }

    public function delete(Project $project): bool
    {
        if (!is_null($project->image_path)) {
            $this->service->deleteImage($project->image_path);
        }

        return ($project->delete()) ? true : false;
    }
}
