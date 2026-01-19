<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body
    class="to-primary-50 min-h-screen bg-gradient-to-br from-white via-gray-50 antialiased dark:from-[#1e1e2e] dark:via-[#1e1e2e] dark:to-[#2d2d3d]">
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div
            class="flex w-full max-w-md flex-col gap-4 rounded-2xl bg-white p-8 shadow-xl dark:bg-[#2d2d3d] dark:shadow-2xl">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                {{-- Logo LAravel --}}
                {{-- <span class="bg-primary-500 mb-1 flex h-12 w-12 items-center justify-center rounded-xl">
                    <x-app-logo-icon class="size-8 fill-current text-white" />
                </span> --}}
                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <div class="flex flex-col gap-6">
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
