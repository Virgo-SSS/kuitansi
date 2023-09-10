<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Role And Permission
    </h2>

    <div class="mb-8">
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Role Item -->
            @foreach($roles as $role)
            <li class="bg-white shadow-md rounded-lg px-4 py-4 relative">
                <!-- Edit Button -->
                @can('edit role')
                <a href="{{ route('role.edit', $role->id) }}">
                    <button class="bg-blue-500 text-white px-2 py-1 rounded-lg absolute top-2 right-2">
                        Edit
                    </button>
                </a>
                @endcan

                <h3 class="text-lg font-semibold mb-2">{{ $role->name }}</h3>
                <!-- Permissions List for Administrator role -->
                <ul class="list-disc list-inside">
                    @foreach($role->permissions as $permission)
                    <li>{{ $permission->name }}</li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
