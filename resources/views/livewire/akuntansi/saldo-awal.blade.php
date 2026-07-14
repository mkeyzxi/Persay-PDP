<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="mx-auto max-w-6xl">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">
                Saldo Awal
            </h1>
            <p class="mt-2 text-gray-600 dark:text-zinc-400">
                Kelola saldo awal tahunan sebagai penentu dana setiap project
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

        <!-- Active Balance Summary Card -->
        @if ($activeBalance)
            <div
                class="mb-6 rounded-xl border border-emerald-300 bg-gradient-to-r from-emerald-50 to-teal-50 p-6 shadow-md dark:border-emerald-700 dark:from-emerald-900/30 dark:to-teal-900/30">
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-500 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-emerald-800 dark:text-emerald-300">
                        Saldo Aktif Saat Ini
                    </h2>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <p class="text-sm text-emerald-600 dark:text-emerald-400">Saldo Awal</p>
                        <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">
                            Rp {{ number_format($activeBalance->amount, 0, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-emerald-600 dark:text-emerald-400">Sisa Saldo</p>
                        <p
                            class="{{ $activeBalance->remaining >= 0 ? 'text-emerald-900 dark:text-emerald-100' : 'text-red-600 dark:text-red-400' }} text-2xl font-bold">
                            Rp {{ number_format($activeBalance->remaining, 0, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-emerald-600 dark:text-emerald-400">Periode</p>
                        <p class="text-lg font-semibold text-emerald-900 dark:text-emerald-100">
                            {{ $activeBalance->period_start->format('d M Y') }} —
                            {{ $activeBalance->period_end->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div
                class="mb-6 rounded-xl border border-amber-300 bg-amber-50 p-6 dark:border-amber-700 dark:bg-amber-900/20">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="font-medium text-amber-700 dark:text-amber-300">
                        Belum ada saldo awal yang aktif untuk periode saat ini. Silakan tambahkan saldo awal baru.
                    </p>
                </div>
            </div>
        @endif

        <!-- Form Input / Edit -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800 dark:border-zinc-700 dark:text-white">
                {{ $isEditing ? 'Edit Saldo Awal' : 'Tambah Saldo Awal Baru' }}
            </h2>

            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Amount -->
                    <div class="sm:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">
                            Jumlah Saldo Awal (Rp)
                        </label>
                        <input type="number" wire:model="amount" step="0.01" min="0"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white"
                            placeholder="Contoh: 33000000">
                        @error('amount')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Period Start -->
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">
                            Tanggal Mulai
                        </label>
                        <input type="date" wire:model="period_start"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                        @error('period_start')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Period End -->
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">
                            Tanggal Akhir
                        </label>
                        <input type="date" wire:model="period_end"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                        @error('period_end')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">
                            Keterangan (Opsional)
                        </label>
                        <textarea wire:model="description" rows="3"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white"
                            placeholder="Catatan tentang saldo awal ini..."></textarea>
                        @error('description')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-4 flex gap-3">
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-6 py-2.5 font-semibold text-white shadow transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        wire:loading.attr="disabled" wire:target="save">

                        <span wire:loading.remove wire:target="save">
                            {{ $isEditing ? 'Perbarui' : 'Simpan' }}
                        </span>
                        <span wire:loading wire:target="save">
                            <svg class="mr-1 inline-block h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                            </svg>
                            Menyimpan...
                        </span>
                    </button>

                    @if ($isEditing)
                        <button type="button" wire:click="resetForm"
                            class="rounded-lg border border-gray-300 bg-gray-100 px-6 py-2.5 font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600">
                            Batal
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Perkembangan Bulanan -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">
            <div
                class="mb-4 flex flex-col gap-4 border-b pb-4 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                    Perkembangan Saldo Bulanan
                </h2>
                <div class="flex items-center gap-3">
                    <label class="text-sm font-medium text-gray-600 dark:text-zinc-400">Tahun:</label>
                    <select wire:model.live="filterYear"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if ($monthlyBreakdown->isNotEmpty())
                {{-- Summary Card --}}
                @php
                    $firstMonth = $monthlyBreakdown->first();
                    $lastMonthWithData = $monthlyBreakdown->last();
                @endphp
                <div class="mb-5 grid grid-cols-1 gap-3 sm:grid-cols-4">
                    <div
                        class="rounded-lg border border-blue-200 bg-blue-50 p-3 dark:border-blue-800 dark:bg-blue-900/20">
                        <p class="text-xs font-medium text-blue-600 dark:text-blue-400">Saldo Awal Periode</p>
                        <p class="text-lg font-bold text-blue-900 dark:text-blue-100">
                            Rp {{ number_format($firstMonth['saldo_awal'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div
                        class="rounded-lg border border-amber-200 bg-amber-50 p-3 dark:border-amber-800 dark:bg-amber-900/20">
                        <p class="text-xs font-medium text-amber-600 dark:text-amber-400">Total Dana Terpakai</p>
                        <p class="text-lg font-bold text-amber-900 dark:text-amber-100">
                            Rp {{ number_format($lastMonthWithData['accumulated_value'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div
                        class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 dark:border-emerald-800 dark:bg-emerald-900/20">
                        <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400">Sisa Saldo Terkini</p>
                        <p
                            class="{{ $lastMonthWithData['remaining'] >= 0 ? 'text-emerald-900 dark:text-emerald-100' : 'text-red-600 dark:text-red-400' }} text-lg font-bold">
                            Rp {{ number_format($lastMonthWithData['remaining'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div
                        class="rounded-lg border border-purple-200 bg-purple-50 p-3 dark:border-purple-800 dark:bg-purple-900/20">
                        <p class="text-xs font-medium text-purple-600 dark:text-purple-400">Persentase Terpakai</p>
                        <p class="text-lg font-bold text-purple-900 dark:text-purple-100">
                            {{ $lastMonthWithData['percentage'] }}%
                        </p>
                    </div>
                </div>

                {{-- Monthly Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="border-b border-gray-200 text-xs uppercase text-gray-500 dark:border-zinc-700 dark:text-zinc-400">
                            <tr>
                                <th class="px-4 py-3">Bulan</th>
                                <th class="px-4 py-3">Kontrak Baru</th>
                                <th class="px-4 py-3">Akumulasi Terpakai</th>
                                <th class="px-4 py-3">Sisa Saldo</th>
                                <th class="min-w-[200px] px-4 py-3">Pemakaian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">
                            @foreach ($monthlyBreakdown as $data)
                                <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        {{ $data['name'] }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-zinc-300">
                                        @if ($data['monthly_value'] > 0)
                                            <span class="font-semibold text-amber-600 dark:text-amber-400">
                                                Rp {{ number_format($data['monthly_value'], 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 dark:text-zinc-500">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                        Rp {{ number_format($data['accumulated_value'], 0, ',', '.') }}
                                    </td>
                                    <td
                                        class="{{ $data['remaining'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} px-4 py-3 font-semibold">
                                        Rp {{ number_format($data['remaining'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="h-2.5 w-full rounded-full bg-gray-200 dark:bg-zinc-600">
                                                <div class="{{ $data['percentage'] <= 50 ? 'bg-emerald-500' : ($data['percentage'] <= 80 ? 'bg-amber-500' : 'bg-red-500') }} h-2.5 rounded-full transition-all duration-500"
                                                    style="width: {{ $data['percentage'] }}%">
                                                </div>
                                            </div>
                                            <span
                                                class="min-w-[3rem] text-xs font-medium text-gray-600 dark:text-zinc-400">
                                                {{ $data['percentage'] }}%
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-300 dark:text-zinc-600"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="mt-3 text-gray-500 dark:text-zinc-400">
                        Tidak ada data saldo untuk tahun <strong>{{ $filterYear }}</strong>.
                    </p>
                    <p class="mt-1 text-sm text-gray-400 dark:text-zinc-500">
                        Pastikan ada saldo awal yang periodenya mencakup tahun ini.
                    </p>
                </div>
            @endif
        </div>

        <!-- Data Table -->
        <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800 dark:border-zinc-700 dark:text-white">
                Daftar Saldo Awal
            </h2>

            @if ($balances->isEmpty())
                <div class="py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400 dark:text-zinc-500"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="mt-4 text-gray-500 dark:text-zinc-400">Belum ada saldo awal yang ditambahkan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="border-b border-gray-200 text-xs uppercase text-gray-500 dark:border-zinc-700 dark:text-zinc-400">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Periode</th>
                                <th class="px-4 py-3">Saldo Awal</th>
                                <th class="px-4 py-3">Sisa Saldo</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Keterangan</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">
                            @foreach ($balances as $index => $balance)
                                <tr
                                    class="{{ $balance->status === 'Aktif' ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : '' }} transition-colors hover:bg-gray-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-4 py-3 text-gray-700 dark:text-zinc-300">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-zinc-300">
                                        <div class="font-medium">
                                            {{ $balance->period_start->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-zinc-400">
                                            s/d {{ $balance->period_end->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                        Rp {{ number_format($balance->amount, 0, ',', '.') }}
                                    </td>
                                    <td
                                        class="{{ $balance->remaining >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} px-4 py-3 font-semibold">
                                        Rp {{ number_format($balance->remaining, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($balance->status === 'Aktif')
                                            <span
                                                class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">
                                                <span
                                                    class="mr-1.5 h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @elseif ($balance->status === 'Kadaluarsa')
                                            <span
                                                class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/50 dark:text-red-300">
                                                Kadaluarsa
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-900/50 dark:text-amber-300">
                                                Belum Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-zinc-400">
                                        {{ $balance->description ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center gap-2">
                                            @if ($confirmingDeleteId === $balance->id)
                                                <span class="mr-2 text-xs text-red-600 dark:text-red-400">Yakin
                                                    hapus?</span>
                                                <button wire:click="delete({{ $balance->id }})"
                                                    class="rounded bg-red-600 px-2 py-1 text-xs font-medium text-white hover:bg-red-700">
                                                    Ya
                                                </button>
                                                <button wire:click="cancelDelete"
                                                    class="rounded bg-gray-300 px-2 py-1 text-xs font-medium text-gray-700 hover:bg-gray-400 dark:bg-zinc-600 dark:text-zinc-300 dark:hover:bg-zinc-500">
                                                    Batal
                                                </button>
                                            @else
                                                <button wire:click="edit({{ $balance->id }})"
                                                    class="rounded bg-blue-100 p-1.5 text-blue-600 transition-colors hover:bg-blue-200 dark:bg-blue-900/50 dark:text-blue-400 dark:hover:bg-blue-900/80"
                                                    title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <button wire:click="confirmDelete({{ $balance->id }})"
                                                    class="rounded bg-red-100 p-1.5 text-red-600 transition-colors hover:bg-red-200 dark:bg-red-900/50 dark:text-red-400 dark:hover:bg-red-900/80"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Info Box -->
        <div class="mt-6 rounded-lg border border-blue-300 bg-blue-50 p-4 dark:border-blue-600 dark:bg-blue-900/20">
            <h3 class="mb-2 font-semibold text-blue-800 dark:text-blue-300">
                Informasi Saldo Awal
            </h3>
            <ul class="list-inside list-disc space-y-1 text-sm text-blue-700 dark:text-blue-400">
                <li>Saldo awal berlaku selama <strong>1 periode</strong> yang Anda tentukan</li>
                <li>Sisa saldo dihitung otomatis: <strong>Saldo Awal − Total Nilai Kontrak Project</strong> dalam
                    periode tersebut</li>
                <li>Periode saldo awal <strong>tidak boleh bertabrakan</strong> satu sama lain</li>
                <li>Setelah periode berakhir, silakan input saldo awal baru untuk periode berikutnya</li>
            </ul>
        </div>

    </div>
</div>
