<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Create User
    </h2>

    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="grid grid-cols-2 gap-6">
            </div>
        </div>

        <x-buttons.submit class="bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900">{{ __('Save') }}</x-buttons.submit>
    </form>
</x-app-layout>
