<div class="min-h-screen bg-zinc-50 p-4 transition-colors md:p-6 dark:bg-zinc-900">
    <div class="mx-auto max-w-full">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('tabel-info') }}" wire:navigate
                class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition-colors hover:text-[#5A6ACF] dark:text-zinc-400 dark:hover:text-[#7B8AEF]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Tabel Info
            </a>

            <div class="mt-2 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 md:text-3xl dark:text-white">
                        {{ $project->spk_number }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-zinc-400">
                        {{ $project->project_name }}
                    </p>
                </div>
                <div class="flex gap-2">
                    @php
                        $statusClass = match ($project->status) {
                            'CLOSED' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                            'OPEN' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                            default => 'bg-gray-100 text-gray-600 dark:bg-zinc-700 dark:text-zinc-400',
                        };
                        $paymentClass = match ($project->payment_status ?? 'unpaid') {
                            'paid' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                            'in_progress' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                            default => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                        };
                        $paymentLabel = match ($project->payment_status ?? 'unpaid') {
                            'paid' => 'Terbayar',
                            'in_progress' => 'Pembayaran In Progress',
                            default => 'Belum Bayar',
                        };
                    @endphp
                    <span class="{{ $statusClass }} rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider">
                        {{ $project->status ?? '-' }}
                    </span>
                    <span class="{{ $paymentClass }} rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider">
                        {{ $paymentLabel }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Info Cards Grid --}}
        <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">
            {{-- Saldo PDP --}}
            <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <p class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-zinc-400">Saldo PDP</p>
                <p class="mt-1 text-lg font-bold text-[#5A6ACF]">
                    Rp {{ number_format($summary['saldo_pdp'], 0, ',', '.') }}
                </p>
            </div>

            {{-- Progress --}}
            <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <p class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-zinc-400">Progress</p>
                <div class="mt-1 flex items-center gap-2">
                    <div class="h-2 flex-1 overflow-hidden rounded-full bg-gray-200 dark:bg-zinc-700">
                        <div class="{{ $project->proggress_percent == 100 ? 'bg-green-500' : 'bg-[#5A6ACF]' }} h-full transition-all"
                            style="width: {{ $project->proggress_percent }}%"></div>
                    </div>
                    <span
                        class="text-sm font-bold text-gray-900 dark:text-white">{{ $project->proggress_percent }}%</span>
                </div>
            </div>

            {{-- Umur --}}
            <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <p class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-zinc-400">Umur Project</p>
                <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">
                    {{ round($summary['umur_hari']) }} <span class="text-xs font-normal text-gray-400">Hari</span>
                </p>
                <p class="text-[10px] text-gray-400">{{ $summary['klaster_umur'] }}</p>
            </div>

            {{-- Total Dokumen SAP --}}
            <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <p class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-zinc-400">Dokumen SAP</p>
                <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">{{ $summary['total_material_issues'] }}
                </p>
                <p class="text-[10px] text-gray-400">{{ $summary['total_items'] }} rincian material</p>
            </div>

            {{-- Qty SAP --}}
            <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <p class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-zinc-400">Total Qty SAP</p>
                <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">
                    {{ number_format($summary['total_qty_sap'], 2, ',', '.') }}</p>
            </div>

            {{-- Qty Installed --}}
            <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <p class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-zinc-400">Total Qty Terpasang</p>
                <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">
                    {{ number_format($summary['total_qty_installed'], 2, ',', '.') }}</p>
            </div>
        </div>

        {{-- Project Detail Info --}}
        <div class="mb-6 grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-zinc-400">
                    Informasi Kontrak</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">No. Kontrak</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $project->contract_number ?? '-' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">Vendor</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $project->vendor_name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">Lokasi</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $project->location ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">Nilai Kontrak</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">
                            Rp {{ number_format($project->contract_value, 0, ',', '.') }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">WBS Number</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $project->wbs_number ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">Unit</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $project->unit_code ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-zinc-400">Tanggal
                    & Status</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">Mulai Kontrak</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">
                            {{ $project->contract_start_date ? $project->contract_start_date->format('d/m/Y') : '-' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">Akhir Kontrak</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">
                            {{ $project->contract_end_date ? $project->contract_end_date->format('d/m/Y') : '-' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">Tgl BASTP</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">
                            {{ $project->bastp_date ? $project->bastp_date->format('d/m/Y') : '-' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">Tgl SLO</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">
                            {{ $project->slo_date ? $project->slo_date->format('d/m/Y') : '-' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">Kategori PDP</dt>
                        <dd class="font-semibold text-[#5A6ACF]">{{ $project->pdp_category ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-zinc-400">Kendala</dt>
                        <dd class="font-medium text-red-500">{{ $project->constraint_note ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Material Issues Section --}}
        <div class="rounded-xl bg-white shadow-md ring-1 ring-gray-200 dark:bg-zinc-800 dark:ring-gray-700">
            <div class="flex items-center justify-between border-b border-gray-100 p-4 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Dokumen SAP & Rincian Material
                </h2>
                <div class="flex gap-2">
                    <button wire:click="expandAll"
                        class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 transition-colors hover:bg-gray-50 dark:border-zinc-600 dark:text-zinc-300 dark:hover:bg-zinc-700">
                        Buka Semua
                    </button>
                    <button wire:click="collapseAll"
                        class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 transition-colors hover:bg-gray-50 dark:border-zinc-600 dark:text-zinc-300 dark:hover:bg-zinc-700">
                        Tutup Semua
                    </button>
                </div>
            </div>

            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($project->materialIssues as $mi)
                    <div>
                        {{-- Material Issue Header --}}
                        <button wire:click="toggleIssue({{ $mi->id }})"
                            class="flex w-full items-center justify-between px-4 py-3 text-left transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                            <div class="flex items-center gap-4">
                                <svg class="{{ in_array($mi->id, $expandedIssues) ? 'rotate-90' : '' }} h-5 w-5 text-gray-400 transition-transform"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                <div>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ $mi->sap_doc_no ?? 'Manual Input' }}
                                    </span>
                                    <span class="ml-2 text-xs text-gray-400">
                                        {{ $mi->header_text }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-zinc-400">
                                <span>
                                    {{ $mi->posting_date ? $mi->posting_date->format('d/m/Y') : '-' }}
                                </span>
                                <span
                                    class="rounded-full bg-blue-50 px-2 py-0.5 font-medium text-[#5A6ACF] dark:bg-blue-900/20">
                                    {{ $mi->items->count() }} item
                                </span>
                                <span class="font-mono font-medium text-gray-900 dark:text-white">
                                    Rp {{ number_format($mi->items->sum('val_currency'), 0, ',', '.') }}
                                </span>
                            </div>
                        </button>

                        {{-- Material Issue Items --}}
                        @if (in_array($mi->id, $expandedIssues))
                            <div
                                class="overflow-x-auto border-t border-gray-50 bg-zinc-50/50 dark:border-zinc-700 dark:bg-zinc-900/30">
                                <table class="w-full min-w-[900px] table-auto text-left text-sm">
                                    <thead>
                                        <tr
                                            class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-zinc-400">
                                            <th class="px-4 py-2 font-semibold">#</th>
                                            <th class="px-4 py-2 font-semibold">Kode Material</th>
                                            <th class="px-4 py-2 font-semibold">Deskripsi</th>
                                            <th class="px-4 py-2 text-center font-semibold">UoM</th>
                                            <th class="px-4 py-2 text-right font-semibold">Qty SAP</th>
                                            <th class="px-4 py-2 text-right font-semibold">Qty Terpasang</th>
                                            <th class="px-4 py-2 text-right font-semibold">Nilai (Rp)</th>
                                            <th class="px-4 py-2 text-center font-semibold">No. Aset</th>
                                            <th class="px-4 py-2 font-semibold">WBS Element</th>
                                            <th class="px-4 py-2 font-semibold">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @foreach ($mi->items as $idx => $item)
                                            <tr class="transition-colors hover:bg-white dark:hover:bg-zinc-800">
                                                <td class="px-4 py-2 text-xs text-gray-400">{{ $idx + 1 }}</td>
                                                <td
                                                    class="whitespace-nowrap px-4 py-2 font-mono text-xs font-medium text-[#5A6ACF]">
                                                    {{ $item->material->sap_material_code ?? '-' }}
                                                </td>
                                                <td class="px-4 py-2 text-xs text-gray-700 dark:text-zinc-300">
                                                    {{ $item->material->material_description ?? '-' }}
                                                </td>
                                                <td class="px-4 py-2 text-center text-xs text-gray-500">
                                                    {{ $item->material->uom ?? '-' }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-2 text-right font-mono text-xs">
                                                    {{ number_format($item->quantity_sap, 2, ',', '.') }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-2 text-right font-mono text-xs">
                                                    {{ number_format($item->quantity_installed, 2, ',', '.') }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-4 py-2 text-right font-mono text-xs font-medium text-gray-900 dark:text-white">
                                                    {{ number_format($item->val_currency, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-2 text-center text-xs">
                                                    @if ($item->asset_number)
                                                        <span
                                                            class="rounded bg-green-50 px-1.5 py-0.5 text-[10px] font-medium text-green-700 dark:bg-green-900/20 dark:text-green-400">
                                                            {{ $item->asset_number }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-2 text-xs text-gray-500">
                                                    {{ $item->wbs_element ?? '-' }}
                                                </td>
                                                <td class="max-w-[150px] truncate px-4 py-2 text-xs text-gray-500"
                                                    title="{{ $item->remarks }}">
                                                    {{ $item->remarks ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot
                                        class="border-t border-gray-200 bg-zinc-50 font-semibold dark:border-zinc-600 dark:bg-zinc-800/50">
                                        <tr class="text-xs">
                                            <td colspan="4"
                                                class="px-4 py-2 text-right text-gray-500 dark:text-zinc-400">Subtotal
                                            </td>
                                            <td
                                                class="whitespace-nowrap px-4 py-2 text-right font-mono text-gray-900 dark:text-white">
                                                {{ number_format($mi->items->sum('quantity_sap'), 2, ',', '.') }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap px-4 py-2 text-right font-mono text-gray-900 dark:text-white">
                                                {{ number_format($mi->items->sum('quantity_installed'), 2, ',', '.') }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap px-4 py-2 text-right font-mono text-gray-900 dark:text-white">
                                                {{ number_format($mi->items->sum('val_currency'), 0, ',', '.') }}
                                            </td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="px-4 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="rounded-full bg-zinc-50 p-4 dark:bg-gray-800">
                                <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="mt-4 font-medium text-gray-500 dark:text-zinc-400">Belum ada dokumen SAP untuk
                                project ini</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
