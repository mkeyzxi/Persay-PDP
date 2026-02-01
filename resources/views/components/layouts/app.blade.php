<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @livewireStyles
</head>

<body class="min-h-screen bg-white dark:bg-zinc-900">
    <x-layouts.app.sidebar :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts.app.sidebar>

    @fluxScripts
</body>

</html>
