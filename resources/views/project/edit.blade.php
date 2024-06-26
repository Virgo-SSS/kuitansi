<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Edit Project
    </h2>

    <form action="{{ route('project.update', $project->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <x-span>Name</x-span>
                <x-inputs.text placeholder="name" name="name" required value="{{ $project->name }}"/>
                @error('name')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
            </label>

            <label class="block mt-4 text-sm">
                <x-span>Number</x-span>
                <x-inputs.number placeholder="Number" name="number" required value="{{ $project->number }}"/>
                @error('number')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
            </label>

            <label class="block mt-4 text-sm">
                <x-span>Block</x-span>
                <x-inputs.number placeholder="Block" name="block" required value="{{ $project->block }}"/>
                @error('block')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
            </label>

            <label class="block mt-4 text-sm">
                <x-span>Type</x-span>
                <x-inputs.text placeholder="Type" name="type" required value="{{ $project->type }}"/>
                @error('type')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
            </label>

            <div class="flex justify-end mt-4">
                <x-buttons.submit>
                    Update
                </x-buttons.submit>
            </div>
        </div>
    </form>

</x-app-layout>
