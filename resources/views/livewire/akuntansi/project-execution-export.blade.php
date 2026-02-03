<div class="min-h-screen bg-zinc-50 p-6 transition-colors dark:bg-zinc-900">
    <div class="mx-auto max-w-4xl">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">
                Download Project Data
            </h1>
            <p class="mt-2 text-gray-600 dark:text-zinc-400">
                Export data project ke file Excel berdasarkan status yang dipilih
            </p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div
                class="mb-4 rounded-lg border border-green-400 bg-green-100 p-4 text-green-700 dark:border-green-600 dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-4 rounded-lg border border-red-400 bg-red-100 p-4 text-red-700 dark:border-red-600 dark:bg-red-900/30 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif



        <!-- Export Options Card -->
        <div class="mt-6 rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800 dark:border-zinc-700 dark:text-white">
                Export Data Project
            </h2>

            <div class="space-y-6">
                <!-- Status Selection -->
                <div class="rounded-lg border border-gray-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-700/30">
                    <label for="selectedStatus" class="mb-2 block text-sm font-medium text-gray-700 dark:text-zinc-300">
                        Pilih Status Project
                    </label>
                    <select id="selectedStatus" wire:model="selectedStatus"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-700 shadow-sm transition-colors focus:border-[#5A6ACF] focus:outline-none focus:ring-2 focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                        <option value="SEMUA">SEMUA STATUS</option>
                        <option value="OPEN">OPEN</option>
                        <option value="CLOSED">CLOSED</option>
                        <option value="DRAFT">DRAFT</option>
                    </select>
                </div>

                <!-- Export Icon Area -->
                <div
                    class="rounded-lg border-2 border-dashed border-[#5A6ACF]/50 bg-[#5A6ACF]/5 p-6 text-center dark:border-[#5A6ACF]/40 dark:bg-[#5A6ACF]/10">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto mb-3 h-12 w-12 text-[#5A6ACF] dark:text-[#7C8AE4]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>

                    <p class="text-sm text-gray-600 dark:text-zinc-400">
                        Klik tombol di bawah untuk mengunduh data project dalam format Excel
                    </p>
                </div>

                <!-- Export Button -->
                <div class="flex justify-center">
                    <button wire:click="export"
                        class="rounded-lg bg-[#5A6ACF] px-8 py-3 font-semibold text-white shadow-lg transition-colors hover:bg-[#4A5ABF] focus:outline-none focus:ring-2 focus:ring-[#5A6ACF] focus:ring-offset-2 dark:focus:ring-offset-[#2d2d3d]"
                        wire:loading.attr="disabled" wire:target="export">

                        <span wire:loading.remove wire:target="export">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 inline-block h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export Excel
                        </span>

                        <span wire:loading wire:target="export">
                            <svg class="mr-2 inline-block h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                            </svg>
                            Mengunduh...
                        </span>
                    </button>
                </div>
            </div>
        </div>
   <!-- Footer Note -->
        <div class="mt-4 text-center text-sm text-gray-500 dark:text-zinc-400">
            File Excel akan otomatis terunduh setelah tombol Export diklik
        </div>
    <!-- Info Box -->
        <div class="mt-6 rounded-lg border border-blue-300 bg-blue-50 p-4 dark:border-blue-600 dark:bg-blue-900/20">
            <h3 class="mb-2 font-semibold text-blue-800 dark:text-blue-300">
                Informasi Export
            </h3>
            <ul class="list-inside list-disc space-y-1 text-sm text-blue-700 dark:text-blue-400">
                <li>Pilih status project yang ingin di-export</li>
                <li>Data akan diunduh dalam format <strong>Excel (.xlsx)</strong></li>
                <li>Pilih <strong>SEMUA</strong> untuk mengunduh seluruh data project</li>
            </ul>
        </div>


    </div>
</div>
