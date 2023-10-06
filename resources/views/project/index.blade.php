<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Projects
    </h2>

    @can('create project')
        <div class="my-2">
            <a href="{{ route('project.create') }}">
                <x-buttons.small-button>
                    Add Project
                </x-buttons.small-button>
            </a>
        </div>
    @endcan
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 my-2">
        <x-inputs.select>
            @foreach($projects as $project)
            <option value="">tests</option>
            @endforeach
        </x-inputs.select>
        <x-inputs.select>
            <option value="">tests</option>
        </x-inputs.select>
        <x-inputs.select>
            <option value="">tests</option>
        </x-inputs.select>
        <x-inputs.select>
            <option value="">tests</option>
        </x-inputs.select>
        <div>
            <x-buttons.small-button>
                Filter
            </x-buttons.small-button>
        </div>
    </div>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        {{ $projects->links('vendor.pagination.custom-tailwind') }}
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Block</th>
                        <th class="px-4 py-3">Number</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($projects as $project)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $project->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $project->block }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $project->number }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $project->type }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    @can('edit project')
                                        <a href="{{ route('project.edit', $project->id) }}">
                                            <x-buttons.small-button>
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </x-buttons.small-button>
                                        </a>
                                    @endcan

                                    @can('delete project')
                                        @livewire('delete-button-confirmation', [
                                            'modalComponentName' => 'delete-project-modal',
                                            'attributes' => json_encode([
                                                'projectId' => $project->id,
                                            ]),
                                        ])
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $projects->links('vendor.pagination.custom-tailwind') }}
    </div>
</x-app-layout>
