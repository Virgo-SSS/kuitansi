<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Create Role
    </h2>

    <div class="bg-white shadow-md rounded-lg px-4 py-4 dark:bg-gray-800">
        <form action="{{ route('role.store') }}" method="POST">
            @csrf
            <!-- Role Name Input -->
            <div class="mb-4">
                @error('name')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror

                <x-label for="name">Role : </x-label>
                <x-inputs.text  id="name"  name="name" placeholder="Role Name" required class="text-black "/>
            </div>

            <!-- Permissions Input -->
            <div class="mb-4">
                @error('permissions')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
                <x-label for="permission">Permissions</x-label>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Card 1 -->
                    @foreach($permissions as $key => $permission)
                        <div class="bg-white p-4 shadow-md rounded-lg dark:bg-gray-800">
                            <h2 class="text-lg font-semibold mb-2 dark:text-gray-200">{{ ucfirst($key) }}</h2>
                            <ul>
                                @foreach($permission as $value)
                                    <li class="flex items-center">
                                        <x-inputs.checkbox name="permissions[]" id="permission" value="{{ $value }}"/>
                                        <x-span class="ml-2">{{ $value }}</x-span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Create Role</button>
        </form>

    </div>
</x-app-layout>
