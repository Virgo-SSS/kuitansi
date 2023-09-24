<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Repository\interfaces\ProjectRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;

class ProjectDependentDropdown extends Component
{
    public Collection $projects;

    public ?Collection $perumahans = null;
    public ?Collection $blocks = null;
    public ?Collection $numbers = null;
    public ?Collection $types = null;

    public ?string $selectedPerumahan = null;
    public ?int $selectedBlock = null;
    public ?int $selectedNumber = null;
    public ?string $selectedType = null;

    public ?Project $selectedProject = null;

    public function mount(): void
    {
        $this->projects = app(ProjectRepositoryInterface::class)->all();
        $this->perumahans = $this->projects->pluck('name')->unique();

        $this->checkOldRequest();
    }

    public function render(): View
    {
        return view('livewire.project-dependent-dropdown');
    }

    public function updatedSelectedPerumahan(string $perumahan): void
    {
        if($perumahan == null) {
            $this->resetCollectionProperty(['Block', 'Number', 'Type']);
            $this->resetSelectedInput(['Perumahan','Block', 'Number', 'Type']);

            return;
        }

        $this->setBlock();

        $this->resetSelectedInput(['Block', 'Number', 'Type']);
    }

    public function updatedSelectedBlock(int $block): void
    {
        if($block == -1) {
            $this->resetCollectionProperty(['Number', 'Type']);
            $this->resetSelectedInput(['Block', 'Number', 'Type']);
            return;
        }

        $this->setNumber();

        $this->resetSelectedInput(['Number', 'Type']);
    }

    public function updatedSelectedNumber(int $number): void
    {
        if($number == -1) {
            $this->resetCollectionProperty(['Type']);
            $this->resetSelectedInput(['Number', 'Type']);
            return;
        }

        $this->setType();
        $this->resetSelectedInput(['Type']);
    }

    public function updatedSelectedType(string $type): void
    {
        if($type == null) {
            $this->resetSelectedInput(['Type', 'Project']);
            return;
        }

        $this->setSelectedProject();
    }

    private function checkOldRequest(): void
    {
        $this->selectedPerumahan = old('project-perumahan') ?? ($this->selectedProject->name ?? null);
        if($this->selectedPerumahan != null) {
            $this->updatedSelectedPerumahan($this->selectedPerumahan);
        }

        $this->selectedBlock = old('project-block') ?? ($this->selectedProject->block ?? null);
        if($this->selectedBlock != null) {
            $this->updatedSelectedBlock($this->selectedBlock);
        }

        $this->selectedNumber = old('project-number') ?? ($this->selectedProject->number ?? null);
        if($this->selectedNumber != null) {
            $this->updatedSelectedNumber($this->selectedNumber);
        }

        $this->selectedType = old('project-type') ?? ($this->selectedProject->type ?? null);
        if($this->selectedType != null) {
            $this->updatedSelectedType($this->selectedType);
        }
    }

    private function resetSelectedInput(array $inputs): void
    {
        foreach($inputs as $input) {
            $selectedInput = 'selected' . ucfirst($input);
            $this->$selectedInput = null;
        }
    }

    private function resetCollectionProperty(array $collections): void
    {
        foreach($collections as $collection) {
            $collectionProperty = strtolower($collection) . 's';
            $this->$collectionProperty = null;
        }
    }

    private function setBlock(): void
    {
        $this->blocks =  $this->projects->filter(function (Project $project) {
            return $project->name == $this->selectedPerumahan;
        })->pluck('block')->unique();
    }

    private function setNumber(): void
    {
        $this->numbers = $this->projects->filter(function (Project $project) {
            return $project->block == $this->selectedBlock && $project->name == $this->selectedPerumahan;
        })->pluck('number')->unique();
    }

    private function setType(): void
    {
        $this->types =  $this->projects->filter(function (Project $project) {
            return $project->number == $this->selectedNumber && $project->block == $this->selectedBlock && $project->name == $this->selectedPerumahan;
        })->pluck('type')->unique();
    }

    private function setSelectedProject(): void
    {
        $this->selectedProject = $this->projects->filter(function (Project $project) {
            return $project->type == $this->selectedType && $project->number == $this->selectedNumber && $project->block == $this->selectedBlock && $project->name == $this->selectedPerumahan;
        })->first();
    }
}
