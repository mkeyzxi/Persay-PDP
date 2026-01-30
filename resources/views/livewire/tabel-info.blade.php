<div class="min-h-screen bg-gray-50 p-4 transition-colors md:p-6 dark:bg-[#1e1e2e]">
    <div class="mx-auto max-w-full">

        <!-- Header -->
        <div class="mb-6 md:mb-8">
            <h1 class="text-2xl font-bold text-gray-900 md:text-3xl dark:text-white">
                Tabel Info Project
            </h1>
            <p class="mt-2 text-sm text-gray-600 md:text-base dark:text-gray-400">
                Temukan dan kelola data project dengan mudah
            </p>
        </div>

        <!-- Filter & Search Card -->
        <div class="mb-6 rounded-xl bg-white p-4 shadow-lg md:p-6 dark:bg-[#2d2d3d]">
            <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">
                Filter & Pencarian
            </h2>

            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <!-- Sort Options -->
                <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                    <div class="flex flex-col gap-1">
                        <label for="tanggalContract" class="text-xs font-medium text-gray-600 dark:text-gray-400">
                            Urutkan Tanggal Kontrak
                        </label>
                        <select id="tanggalContract" wire:model.live="sortField"
                            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm transition-colors focus:border-[#5A6ACF] focus:outline-none focus:ring-2 focus:ring-[#5A6ACF]/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="">-- Pilih Urutan --</option>
                            <option value="contract_end_date_asc">Tgl Berakhir ↑ Terlama</option>
                            <option value="contract_end_date_desc">Tgl Berakhir ↓ Terbaru</option>
                            <option value="saldo_pdp_asc">Saldo PDP ↑ Terkecil</option>
                            <option value="saldo_pdp_desc">Saldo PDP ↓ Terbesar</option>
                            <option value="umur_asc">Umur ↑ Terkecil</option>
                            <option value="umur_desc">Umur ↓ Terbesar</option>
                        </select>
                    </div>
                </div>

                <!-- Search & Clear -->
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div class="relative flex-1 sm:min-w-[250px]">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Cari SPK, Nama Project, Status..."
                            class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-10 pr-4 text-sm shadow-sm transition-colors focus:border-[#5A6ACF] focus:outline-none focus:ring-2 focus:ring-[#5A6ACF]/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                    </div>
                    <button wire:click="cleanSort"
                        class="flex items-center justify-center gap-2 rounded-lg bg-gray-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Filter
                    </button>
                </div>
            </div>

            <!-- Active Filters Info -->
            @if ($search || $sortField)
                <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-gray-200 pt-4 dark:border-gray-600">
                    <span class="text-xs text-gray-500 dark:text-gray-400">Filter aktif:</span>
                    @if ($search)
                        <span
                            class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                            Pencarian: "{{ $search }}"
                        </span>
                    @endif
                    @if ($sortField)
                        <span
                            class="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                            Urutan: {{ $sortField }}
                        </span>
                    @endif
                </div>
            @endif
        </div>

        <!-- Data Summary -->
        <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Menampilkan <span class="font-semibold text-gray-800 dark:text-white">{{ $projects->count() }}</span>
                dari <span class="font-semibold text-gray-800 dark:text-white">{{ $projects->total() }}</span> project
            </p>
            <div class="flex items-center gap-2">
                <label for="perPage" class="text-sm text-gray-600 dark:text-gray-400">Per halaman:</label>
                <select id="perPage" wire:model.live="perPage"
                    class="rounded-lg border border-gray-300 bg-white px-2 py-1 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        <!-- Table Card -->
        <div class="rounded-xl bg-white shadow-lg dark:bg-[#2d2d3d]">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1400px] table-auto text-left text-sm">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="whitespace-nowrap px-4 py-3">No SPK / Project</th>
                            <th class="whitespace-nowrap px-4 py-3">Tgl Berakhir Kontrak</th>
                            <th class="whitespace-nowrap px-4 py-3 text-right">Saldo PDP (Rp)</th>
                            <th class="whitespace-nowrap px-4 py-3 text-center">Umur (Hari)</th>
                            <th class="whitespace-nowrap px-4 py-3 text-center">Progress</th>
                            <th class="whitespace-nowrap px-4 py-3 text-center">Kategori</th>
                            <th class="whitespace-nowrap px-4 py-3">Ket. Kategori</th>
                            <th class="whitespace-nowrap px-4 py-3">Tgl BAST</th>
                            <th class="whitespace-nowrap px-4 py-3">Tgl SLO</th>
                            <th class="whitespace-nowrap px-4 py-3">Kendala</th>
                            <th class="whitespace-nowrap px-4 py-3 text-center">Tindak Lanjut</th>
                            <th class="whitespace-nowrap px-4 py-3">Ket. Tindak Lanjut</th>
                            <th class="whitespace-nowrap px-4 py-3">Target Selesai</th>
                            <th class="whitespace-nowrap px-4 py-3 text-center">Status</th>
                            <th class="whitespace-nowrap px-4 py-3 text-center">Klaster Umur</th>
                            <th class="whitespace-nowrap px-4 py-3 text-center">Umur (Bulan)</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-300">
                        @forelse($projects as $p)
                            <tr
                                class="{{ $loop->even ? 'bg-gray-50/50 dark:bg-gray-800/20' : '' }} border-b border-gray-200 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700/30">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-900 dark:text-white">{{ $p->spk_number }}</div>
                                    <div class="mt-0.5 max-w-[200px] truncate text-xs text-gray-500 dark:text-gray-400"
                                        title="{{ $p->project_name }}">
                                        {{ $p->project_name }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    {{ $p->contract_end_date ? \Carbon\Carbon::parse($p->contract_end_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 text-right font-mono font-medium text-gray-900 dark:text-white">
                                    {{ number_format($p->saldo_pdp, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-center">
                                    <span class="font-medium">{{ round($p->umur_hari) }}</span>
                                    <span class="text-xs text-gray-500">hari</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="{{ $p->proggress_percent == 100 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' }} inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                                        {{ $p->proggress_percent }}%
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-semibold text-[#5A6ACF]">{{ $p->pdp_category ?? '-' }}</span>
                                </td>
                                <td class="max-w-[200px] px-4 py-3">
                                    <div class="truncate text-xs" title="{{ $p->ket_kategori }}">
                                        {{ $p->ket_kategori }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    {{ $p->bastp_date ? \Carbon\Carbon::parse($p->bastp_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    {{ $p->slo_date ? \Carbon\Carbon::parse($p->slo_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="max-w-[150px] px-4 py-3">
                                    <div class="truncate text-xs text-red-600 dark:text-red-400"
                                        title="{{ $p->constraint_note }}">
                                        {{ $p->constraint_note ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-medium text-[#5A6ACF]">{{ $p->follow_up_code ?? '-' }}</span>
                                </td>
                                <td class="max-w-[150px] px-4 py-3">
                                    <div class="truncate text-xs" title="{{ $p->ket_tindak_lanjut }}">
                                        {{ $p->ket_tindak_lanjut ?? '-' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    {{ $p->target_completion_date ? \Carbon\Carbon::parse($p->target_completion_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $statusClass = match ($p->status) {
                                            'CLOSED'
                                                => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'OPEN'
                                                => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'DRAFT' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                            default
                                                => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        };
                                    @endphp
                                    <span
                                        class="{{ $statusClass }} inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                                        {{ $p->status ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                        {{ $p->klaster_umur }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-center">
                                    @php
                                        $totalHari = $p->umur_hari;
                                        $bulan = intdiv($totalHari, 30);
                                        $hari = $totalHari % 30;
                                    @endphp
                                    <span class="font-semibold">{{ $bulan }}</span>
                                    <span class="text-xs text-gray-500">bln</span>
                                    <span class="font-semibold">{{ $hari }}</span>
                                    <span class="text-xs text-gray-500">hr</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="mb-4 h-12 w-12 text-gray-300 dark:text-gray-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400">Belum ada data project yang
                                            tersedia.</p>
                                        @if ($search)
                                            <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">
                                                Coba ubah kata kunci pencarian Anda
                                            </p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($projects->hasPages())
                <div class="border-t border-gray-200 px-4 py-4 dark:border-gray-700">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>

        <!-- Footer Info -->
        <div class="mt-4 text-center text-xs text-gray-500 dark:text-gray-400">
            Data diperbarui secara real-time • Scroll ke kanan untuk melihat kolom lainnya
        </div>

    </div>
</div>
