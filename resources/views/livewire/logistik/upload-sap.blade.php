<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="mx-auto max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Upload SAP - Logistik</h1>
            <p class="mt-2 text-gray-600 dark:text-zinc-400">Upload file Excel SAP untuk import data secara bulk</p>
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
     <!-- Info Box -->
        <div class="mt-6 rounded-lg border border-blue-300 bg-blue-50 p-4 dark:border-blue-600 dark:bg-blue-900/20">
            <h3 class="mb-2 font-semibold text-blue-800 dark:text-blue-300">Tips Upload</h3>
            <ul class="list-inside list-disc space-y-1 text-sm text-blue-700 dark:text-blue-400">
                <li>Pastikan format file Excel sesuai dengan template SAP</li>
                <li>Data akan otomatis membuat Project, Material Issue, dan Items</li>
                <li>Untuk input manual, gunakan menu <strong>Manual Input</strong></li>
            </ul>
        </div>
        <!-- Upload File SAP -->
        <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800 dark:border-zinc-700 dark:text-white">

                Upload File Excel SAP
            </h2>

            <form wire:submit.prevent="uploadSap">
                <div class="space-y-4">
                    <!-- File Input -->
                    <div
                        class="rounded-lg border-2 border-dashed border-green-400 bg-green-50 p-6 text-center dark:border-green-600 dark:bg-green-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto mb-3 h-12 w-12 text-green-500 dark:text-green-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <label class="mb-2 block text-sm font-medium text-green-800 dark:text-green-300">
                            Pilih atau seret file Excel ke sini
                        </label>
                        <input type="file" id="sapFile" wire:model="sapFile"
                            class="mx-auto block w-full max-w-md rounded-lg border border-green-300 bg-white px-4 py-2 text-sm file:mr-4 file:rounded file:border-0 file:bg-green-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-green-600 dark:border-green-600 dark:bg-zinc-700 dark:text-white">
                        <span class="mt-2 block text-xs text-green-600 dark:text-green-400">
                            Format yang didukung: .xlsx, .xls, .csv
                        </span>
                        @error('sapFile')
                            <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Upload Button -->
                    <div class="flex justify-center">
                        <button type="submit"
                            class="rounded-lg bg-green-500 px-8 py-3 font-semibold text-white shadow-lg transition-colors hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                            wire:loading.attr="disabled" wire:target="sapFile, uploadSap">
                            <span wire:loading.remove wire:target="uploadSap">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 inline-block h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Upload & Import Data
                            </span>
                            <span wire:loading wire:target="uploadSap">
                                <svg class="mr-2 inline-block h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Mengupload...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>



        <!-- Link to Manual Input -->
        <div class="mt-4 text-center">
            <a href="{{ route('logistik.manual-input') }}"
                class="text-primary-600 hover:text-primary-700 dark:text-primary-400 inline-flex items-center text-sm font-medium underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Atau gunakan Input Manual untuk entry data satu per satu
            </a>
        </div>
    </div>
</div>
