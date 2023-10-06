<?php

namespace App\Http\Controllers;

use App\Actions\Project\Interfaces\CreateProjectActionInterface;
use App\Actions\Project\Interfaces\DeleteProjectActionInterface;
use App\Actions\Project\Interfaces\UpdateProjectActionInterface;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Repository\interfaces\ProjectRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectRepositoryInterface $repository
    ){}

    public function index(Request $request): View
    {
        $this->authorize('view project page');

        $allProjects = $this->repository->all()->unique('name'); // -> for filter

        $projects = $this->repository->paginate($request->all(['name', 'block','type','number']));

        return view('project.index', compact('projects', 'allProjects'));
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
}
