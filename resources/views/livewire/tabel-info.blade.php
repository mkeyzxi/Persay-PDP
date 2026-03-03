<div class="min-h-screen bg-zinc-50 p-4 transition-colors md:p-6 dark:bg-zinc-900">
    <div class="mx-auto max-w-full">

        <div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 md:text-3xl dark:text-white">
                    Tabel Info Project
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-zinc-400">
                    Kelola dan pantau data project dalam satu dasbor
                </p>
            </div>

            <div class="flex gap-4">
                <div
                    class="rounded-lg border border-gray-100 bg-white px-4 py-2 shadow-sm dark:border-gray-700 dark:bg-zinc-800">
                    <p class="text-[10px] uppercase tracking-wider text-gray-500">Total Project</p>
                    <p class="text-lg font-bold text-[#5A6ACF]">{{ $projects->total() }}</p>
                </div>
            </div>
        </div>

        <div
            class="overflow-hidden rounded-xl bg-white shadow-md ring-1 ring-gray-200 dark:bg-zinc-800 dark:ring-gray-700">

            <div
                class="flex flex-col gap-4 border-b border-gray-100 p-4 lg:flex-row lg:items-center lg:justify-between dark:border-gray-700">

                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative min-w-[300px]">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Cari SPK atau nama project..."
                            class="w-full rounded-lg border-gray-200 bg-zinc-50 py-2 pl-10 pr-4 text-sm focus:border-[#5A6ACF] focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                    </div>

                    <select wire:model.live="sortField"
                        class="rounded-lg border-gray-200 bg-zinc-50 px-2 py-2 text-sm focus:border-[#5A6ACF] focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                        <option value="">Urutkan Berdasarkan</option>
                        <option value="contract_end_date_asc">Tgl Berakhir ↑</option>
                        <option value="contract_end_date_desc">Tgl Berakhir ↓</option>
                        <option value="saldo_pdp_asc">Saldo PDP ↑</option>
                        <option value="saldo_pdp_desc">Saldo PDP ↓</option>
                    </select>

                    <select wire:model.live="perPage"
                        class="rounded-lg border-gray-200 bg-zinc-50 px-2 py-2 text-sm focus:border-[#5A6ACF] focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                        <option value="10">10 Baris</option>
                        <option value="25">25 Baris</option>
                        <option value="50">50 Baris</option>
                    </select>

                    @if ($search || $sortField)
                        <button wire:click="cleanSort"
                            class="flex items-center gap-1 text-sm font-medium text-red-500 transition-colors hover:text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd" />
                            </svg>
                            Reset
                        </button>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500 dark:text-zinc-400">
                        Menampilkan {{ $projects->firstItem() ?? 0 }}-{{ $projects->lastItem() ?? 0 }}
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1400px] table-auto text-left text-sm">
                    <thead
                        class="border-b border-gray-100 bg-zinc-50/50 text-xs uppercase tracking-wider text-gray-500 dark:border-gray-700 dark:bg-gray-800/50 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-4 font-semibold">No SPK / Project</th>
                            <th class="px-4 py-4 font-semibold">Tgl Berakhir</th>
                            <th class="px-4 py-4 text-right font-semibold">Saldo PDP (Rp)</th>
                            <th class="px-4 py-4 text-center font-semibold">Umur</th>
                            <th class="px-4 py-4 text-center font-semibold">Progress</th>
                            <th class="px-4 py-4 text-center font-semibold">Kategori</th>
                            <th class="px-4 py-4 font-semibold">Ket. Kategori</th>
                            <th class="px-4 py-4 font-semibold">Tgl BAST / SLO</th>
                            <th class="px-4 py-4 font-semibold">Kendala</th>
                            <th class="px-4 py-4 text-center font-semibold">Tindak Lanjut</th>
                            <th class="px-4 py-4 text-center font-semibold">Status</th>
                            @if (auth()->user()->role == 'admin' || auth()->user()->role == 'akuntansi')
                                <th class="px-4 py-4 text-center font-semibold">Pembayaran</th>
                            @endif
                            <th class="px-4 py-4 text-center font-semibold">Klaster Umur</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700 dark:divide-gray-700 dark:text-zinc-300">
                        @forelse($projects as $p)
                            <tr wire:click="$dispatch('navigate-to', { url: '{{ route('project.detail', $p->id) }}' })"
                                onclick="window.location='{{ route('project.detail', $p->id) }}'"
                                class="group cursor-pointer transition-colors hover:bg-blue-50/30 dark:hover:bg-blue-900/10">
                                <td class="px-4 py-4">
                                    <div
                                        class="font-bold text-gray-900 transition-colors group-hover:text-[#5A6ACF] dark:text-white">
                                        {{ $p->spk_number }}</div>
                                    <div class="mt-0.5 max-w-[180px] truncate text-[11px] text-gray-500"
                                        title="{{ $p->project_name }}">
                                        {{ $p->project_name }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-4">
                                    {{ $p->contract_end_date ? \Carbon\Carbon::parse($p->contract_end_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-4 text-right font-mono font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ number_format($p->saldo_pdp, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <span class="block font-semibold">{{ round($p->umur_hari) }} <span
                                            class="text-[10px] font-normal text-gray-400">Hari</span></span>
                                    <span class="text-[10px] text-gray-400">({{ intdiv($p->umur_hari, 30) }} bln
                                        {{ $p->umur_hari % 30 }} hr)</span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <div
                                            class="h-1.5 w-16 overflow-hidden rounded-full bg-gray-200 dark:bg-zinc-700">
                                            <div class="{{ $p->proggress_percent == 100 ? 'bg-green-500' : 'bg-[#5A6ACF]' }} h-full"
                                                style="width: {{ $p->proggress_percent }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-bold">{{ $p->proggress_percent }}%</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="text-xs font-semibold text-[#5A6ACF]">{{ $p->pdp_category ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="max-w-[150px] truncate text-[11px]" title="{{ $p->ket_kategori }}">
                                        {{ $p->ket_kategori }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-4">
                                    <div class="text-[11px]">B:
                                        {{ $p->bastp_date ? \Carbon\Carbon::parse($p->bastp_date)->format('d/m/Y') : '-' }}
                                    </div>
                                    <div class="text-[11px]">S:
                                        {{ $p->slo_date ? \Carbon\Carbon::parse($p->slo_date)->format('d/m/Y') : '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="max-w-[120px] truncate text-[11px] text-red-500"
                                        title="{{ $p->constraint_note }}">
                                        {{ $p->constraint_note ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="rounded bg-blue-50 px-2 py-1 text-[10px] font-bold text-[#5A6ACF] dark:bg-blue-900/20">
                                        {{ $p->follow_up_code ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @php
                                        $statusClass = match ($p->status) {
                                            'CLOSED'
                                                => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'OPEN'
                                                => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                            default => 'bg-gray-100 text-gray-600 dark:bg-zinc-700 dark:text-zinc-400',
                                        };
                                    @endphp
                                    <span
                                        class="{{ $statusClass }} rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider">
                                        {{ $p->status ?? '-' }}
                                    </span>
                                </td>
                                @if (auth()->user()->role == 'admin' || auth()->user()->role == 'akuntansi')
                                    <td class="px-4 py-4 text-center">
                                        @php
                                            $paymentClass = match ($p->payment_status ?? 'unpaid') {
                                                'paid'
                                                    => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                                'in_progress'
                                                    => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                                default
                                                    => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                            };
                                            $paymentLabel = match ($p->payment_status ?? 'unpaid') {
                                                'paid' => 'Terbayar',
                                                'in_progress' => 'In Progress',
                                                default => 'Belum Bayar',
                                            };
                                        @endphp
                                        <span
                                            class="{{ $paymentClass }} rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider">
                                            {{ $paymentLabel }}
                                        </span>
                                    </td>
                                @endif
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full bg-purple-50 px-2 py-0.5 text-[10px] font-medium text-purple-700 dark:bg-purple-900/20 dark:text-purple-300">
                                        {{ $p->klaster_umur }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="rounded-full bg-zinc-50 p-4 dark:bg-gray-800">
                                            <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        </div>
                                        <p class="mt-4 font-medium text-gray-500 dark:text-zinc-400">Tidak ada data
                                            yang ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-100 bg-zinc-50/50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800/30">
                {{ $projects->links() }}
            </div>
        </div>

        <div class="mt-4 flex items-center justify-center gap-2 text-[10px] uppercase tracking-widest text-gray-400">
            <svg class="animate-bounce-x h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
            Geser kanan untuk detail
        </div>

    </div>
</div>
