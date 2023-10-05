<?php

namespace App\Http\Livewire;

use App\Actions\Project\Interfaces\DeleteProjectActionInterface;
use App\Models\Project;
use App\Trait\ToastTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Redirector;
use LivewireUI\Modal\ModalComponent;

class DeleteProjectModal extends ModalComponent
{
    use ToastTrait, AuthorizesRequests;

    public Project $project;

    public function mount(int $projectId)
    {
        $this->project = Project::findOrFail($projectId);
    }

    public function render(): View
    {
        return view('project.delete-project-modal');
    }

    public function deleteProject(DeleteProjectActionInterface $action): Redirector
    {
        $this->authorize('delete project');

        $action->handle($this->project);

        $this->toastSuccess('Project deleted successfully');

        $this->project = new Project();

        return redirect()->to(route('project.index'));
    }
}
