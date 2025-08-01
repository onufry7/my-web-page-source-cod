<?php

namespace App\Http\Controllers;

use App\Enums\ProjectCategory;
use App\Exceptions\FileException;
use App\Filters\ProjectFilter;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\Technology;
use App\Repositories\ProjectRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(ProjectFilter $filters, ProjectRepository $projectRepository): View
    {
        return view('project.index')->with([
            'projects' => $projectRepository->projectsPaginated($filters),
            'categories' => ProjectCategory::class,
        ]);
    }

    public function create(): View
    {
        return view('project.create')->with([
            'technologies' => Technology::all(),
            'categories' => ProjectCategory::class,
        ]);
    }

    public function store(ProjectRequest $request, ProjectRepository $projectRepository): RedirectResponse
    {
        try {
            $project = $projectRepository->store($request);

            return $project
                ? to_route('project.show', compact('project'))->banner(__('Added project :name.', ['name' => $project->name]))
                : to_route('project.create')->withInput()->dangerBanner(__('Failed to add project!'));
        } catch (FileException $e) {
            return to_route('project.create')->withInput()->dangerBanner($e->getCustomMessage());
        }
    }

    public function show(Project $project): View
    {
        Gate::authorize('view', $project);

        return view('project.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        return view('project.edit', compact('project'))->with([
            'technologies' => Technology::all(),
            'categories' => ProjectCategory::class,
        ]);
    }

    public function update(ProjectRequest $request, Project $project, ProjectRepository $projectRepository): RedirectResponse
    {
        try {
            return $projectRepository->update($request, $project)
                ? to_route('project.show', compact('project'))->banner(__('Updated project :name.', ['name' => $project->name]))
                : to_route('project.edit', compact('project'))->dangerBanner(__('Failed to update project!'));
        } catch (FileException $e) {
            return to_route('project.edit', compact('project'))->dangerBanner($e->getCustomMessage());
        }
    }

    public function destroy(Project $project, ProjectRepository $projectRepository): RedirectResponse
    {
        try {
            return $projectRepository->delete($project)
                ? to_route('project.index')->banner(__('Deleted project :name.', ['name' => $project->name]))
                : to_route('project.show', compact('project'))->dangerBanner(__('Failed to delete project!'));
        } catch (FileException $e) {
            return to_route('project.show', compact('project'))->dangerBanner($e->getCustomMessage());
        }
    }
}
