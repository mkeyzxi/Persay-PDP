<div
    class="relative flex h-full w-full flex-col items-center justify-center overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-800">

    <div
        class="bg-primary-500 pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full opacity-10 blur-2xl">
    </div>
    <div class="bg-primary-500 pointer-events-none absolute bottom-4 left-4 h-12 w-12 rounded-full opacity-5 blur-sm">
    </div>

    <div class="relative z-10 text-center">
        <h3 class="text-primary-500 text-7xl font-bold leading-tight">
            {{ $numberStatus }}
        </h3>

        <span class="text-sm font-semibold uppercase tracking-wide text-zinc-600 dark:text-zinc-400">
            {{ $projectStatus == 'CLOSED' ? 'Selesai' : ($projectStatus == 'OPEN' ? 'In Progress' : 'Draft') }}
        </span>
    </div>
</div>
