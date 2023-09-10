<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('layouts.partials.app_styles')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/tailwind.output.css', 'resources/js/event.js'])
</head>
<body class="font-sans antialiased">
<!-- Page Content -->
<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
    <x-desktop-sidebar></x-desktop-sidebar>
    <x-mobile-sidebar></x-mobile-sidebar>
    <div class="flex flex-col flex-1 w-full">
        <x-header></x-header>
        <main class="h-full pb-16 overflow-y-auto">
            <div class="container px-6 mx-auto grid">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

@stack('modals')
@livewireScripts
@livewire('livewire-ui-modal')
@include('layouts.partials.app_scripts')
</body>
</html>
