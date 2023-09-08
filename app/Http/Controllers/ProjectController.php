<?php

namespace App\Http\Controllers;

use App\Actions\Project\interface\CreateProjectActionInterface;
use App\Actions\Project\interface\DeleteProjectActionInterface;
use App\Actions\Project\interface\UpdateProjectActionInterface;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $this->authorize('view project page');

        $projects = Project::paginate(10);

        return view('project.index', compact('projects'));
    }

    public function create(): View
    {
        $this->authorize('create project');

        return view('project.create');
    }

    public function store(StoreProjectRequest $request, CreateProjectActionInterface $action): RedirectResponse
    {
        $this->authorize('create project');

        $action->handle($request->validated());

        return redirect()->route('project.index')->with('success', 'Project created successfully');
    }

    public function edit(Project $project): View
    {
        $this->authorize('edit project');

        return view('project.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project, UpdateProjectActionInterface $action): RedirectResponse
    {
        $this->authorize('edit project');

        $action->handle($request->validated(),$project);

        return redirect()->route('project.index')->with('success', 'Project updated successfully');
    }

    public function destroy(Project $project, DeleteProjectActionInterface $action): RedirectResponse
    {
        $this->authorize('delete project');

        $action->handle($project);

        return redirect()->route('project.index')->with('success', 'Project deleted successfully');
    }
}
