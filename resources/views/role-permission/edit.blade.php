<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
       Edit Role
    </h2>

    <div class="bg-white shadow-md rounded-lg px-4 py-4 dark:bg-gray-800">
        <form action="{{ route('role.store') }}" method="POST">
            @csrf
            <!-- Role Name Input -->
            <div class="mb-4">
                <x-errors.default for="name"/>
                <x-label for="name">Role : </x-label>
                <x-inputs.default type="text" id="name"  name="name" placeholder="Role Name"  value="{{ $role->name }}" required class="pl-10 text-black"/>
            </div>

            <!-- Permissions Input -->
            <div class="mb-4">
                <x-errors.default for="permissions"/>
                <x-label for="permission">Permissions</x-label>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($permissions as $permission)
                        <label class="inline-flex items-center">
                            <x-inputs.checkbox name="permissions[]" id="permission" value="{{ $permission }}" checked=""/>
                            <x-span class="ml-2">{{ $permission }}</x-span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Create Role</button>
        </form>

    </div>
</x-app-layout>
