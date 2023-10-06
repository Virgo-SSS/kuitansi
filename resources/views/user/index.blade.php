<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Index User
    </h2>

    @can('create user')
        <div class="my-2">
            <a href="{{ route('user.create') }}">
                <x-buttons.small-button>
                    Add User
                </x-buttons.small-button>
            </a>
        </div>
    @endcan
    <form action="" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 my-2">
            <x-inputs.select name="role">
                <option value="">Filter By Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @selected(request('role') == $role->id) >{{ ucfirst($role->name) }}</option>
                @endforeach
            </x-inputs.select>
            <x-inputs.text name="uuid" value="{{ request('uuid') }}" placeholder="Filter By UUID" />
            <x-inputs.text name="name" value="{{ request('name') }}" placeholder="Filter By Name"/>

            <div class="mt-1">
                <x-buttons.submit>
                    Filter
                </x-buttons.submit>
                <a href="{{ route('user.index') }}">
                    <x-buttons.small-button>
                        Clear
                    </x-buttons.small-button>
                </a>
            </div>
        </div>
    </form>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">UUID</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($users as $user)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $user->uuid }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $user->name }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $user->email }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        @if($loop->first)
                                            {{ ucfirst($role->name) }}
                                        @else
                                            , {{ ucfirst($role->name) }}
                                        @endif
                                    @endforeach
                                @else
                                    No Role
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1">
                                    @can('edit user')
                                        <a href="{{ route('user.edit', $user->id) }}">
                                            <x-buttons.small-button>
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </x-buttons.small-button>
                                        </a>
                                    @endcan

                                    @if($user->name != 'Admin')
                                        @can('delete user')
                                            @livewire('delete-button-confirmation', [
                                                'modalComponentName' => 'delete-user-modal',
                                                'attributes' => json_encode([
                                                    'userId' => $user->id,
                                                ]),
                                            ])
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links('vendor.pagination.custom-tailwind') }}
    </div>

    <x-slot name="scripts">
        <script>
            window.addEventListener('userDeleted', event => {
                window.location.reload();
            });
        </script>
    </x-slot>
</x-app-layout>
