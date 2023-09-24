<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Edit User
    </h2>

    <form action="{{ route('user.update', $user) }}" method="POST" style="width: 50%">
        @csrf
        @method('PUT')
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <x-span>UUID</x-span>
                @error('uuid')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
                <x-inputs.text placeholder="Uuid" name="uuid" required value="{{ $user->uuid }}"/>
            </label>

            <label class="block mt-4 text-sm">
                <x-span>Name</x-span>
                @error('name')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
                <x-inputs.text placeholder="Name" name="name" required value="{{ $user->name }}"/>
            </label>

            <label class="block mt-4 text-sm">
                <x-span>Email</x-span>
                @error('email')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
                <x-inputs.text placeholder="Email" name="email" required value="{{ $user->email }}"/>
            </label>

            <label class="block mt-4 text-sm">
                <x-span>Password</x-span>
                @error('password')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
                <x-inputs.password placeholder="Password" name="password"/>
            </label>

            <label class="block mt-4 text-sm">
                <x-span>Confirmation Password</x-span>
                @error('password_confirmation')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
                <x-inputs.password placeholder="Confirmation Password" name="password_confirmation"/>
            </label>

            <label class="block mt-4 text-sm">
                <x-span>Role</x-span>
                @error('password_confirmation')
                    <x-message.error>{{ $message }}</x-message.error>
                @enderror
                <x-inputs.select name="role" required>
                    <option value="" disabled selected>Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-inputs.select>
            </label>

            <div class="flex justify-end mt-4">
                <x-buttons.submit>
                    Create
                </x-buttons.submit>
            </div>
        </div>
    </form>

</x-app-layout>
