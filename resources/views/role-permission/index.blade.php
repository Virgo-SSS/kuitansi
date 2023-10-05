<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Role And Permission
    </h2>

    <!-- Role Name Input -->
    <div class="mb-4">
        <div class="w-60 flex gap-4">
            <x-inputs.select>
                    <option value="" selected>Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" data-id="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </x-inputs.select>
            @can('edit roles')
                <a href="#" class="mt-1" id="edit-role-button">
                    <x-buttons.small-button>
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                        </svg>
                    </x-buttons.small-button>
                </a>
            @endcan
        </div>
    </div>

    <!-- Permissions Input -->
    @foreach($roles as $role)
        <div class="mb-4 role-permissions" id="permissions-{{ $role->name }}" style="display: none">
            <x-label for="permission">Permissions</x-label>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Card 1 -->
                @foreach($permissions as $key => $permission)
                    <div class="bg-white p-4 shadow-md rounded-lg dark:bg-gray-800">
                        <h2 class="text-lg font-semibold mb-2 dark:text-gray-200">{{ ucfirst($key) }}</h2>
                        <ul>
                            @foreach($permission as $value)
                                <li class="flex items-center">
                                    @if($role->hasPermissionTo($value))
                                        <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" color="red" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                    <x-span class="ml-2">{{ $value }}</x-span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                // show permissions based on role after page load, and don't on change
                $('select').on('change', function () {
                    var role = $(this).val();
                    var editUrl = "{{ route('role.edit', ':id') }}";

                    var id = $(this).find(':selected').data('id');
                    editUrl = editUrl.replace(':id', id);

                    if(role !== '') {
                        $(".role-permissions").hide();
                        $('#permissions-' + role).show();
                        $('#edit-role-button').attr('href', editUrl);
                    } else {
                        $(".role-permissions").hide();
                        $('#edit-role-button').attr('href', '#');
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
