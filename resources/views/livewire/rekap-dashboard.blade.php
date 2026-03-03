<div class="flex flex-col gap-6 rounded-xl bg-white p-5 shadow-sm dark:bg-zinc-800">

    {{-- Header with Filters --}}
    <div
        class="flex flex-col gap-4 border-b border-zinc-200 pb-4 md:flex-row md:items-center md:justify-between dark:border-zinc-700">
        <div>
            <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">
                Rekap Selisih & SAP
            </h3>
            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                Data selisih material (Qty SAP - Qty Terpasang) dan nilai SAP per bulan
            </p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Year Selector --}}
            <select wire:model.live="selectedYear"
                class="rounded-lg border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-[#5A6ACF] dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100">
                @foreach ($availableYears as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>

            {{-- Month Selector --}}
            <select wire:model.live="selectedMonth"
                class="rounded-lg border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-[#5A6ACF] dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100">
                <option value="">Semua Bulan</option>
                @foreach ($namaBulan as $num => $nama)
                    <option value="{{ $num }}">{{ $nama }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 gap-3 md:grid-cols-5">
        <div class="rounded-xl border border-blue-100 bg-blue-50/50 p-3 dark:border-blue-900/30 dark:bg-blue-900/10">
            <p class="text-[10px] uppercase tracking-wider text-blue-600 dark:text-blue-400">Total Item</p>
            <p class="mt-1 text-xl font-bold text-blue-700 dark:text-blue-300">
                {{ number_format($totals->total_items ?? 0, 0) }}
            </p>
        </div>
        <div
            class="rounded-xl border border-indigo-100 bg-indigo-50/50 p-3 dark:border-indigo-900/30 dark:bg-indigo-900/10">
            <p class="text-[10px] uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Qty SAP</p>
            <p class="mt-1 text-xl font-bold text-indigo-700 dark:text-indigo-300">
                {{ number_format($totals->total_qty_sap ?? 0, 2, ',', '.') }}
            </p>
        </div>
        <div
            class="rounded-xl border border-emerald-100 bg-emerald-50/50 p-3 dark:border-emerald-900/30 dark:bg-emerald-900/10">
            <p class="text-[10px] uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Qty Terpasang</p>
            <p class="mt-1 text-xl font-bold text-emerald-700 dark:text-emerald-300">
                {{ number_format($totals->total_qty_installed ?? 0, 2, ',', '.') }}
            </p>
        </div>
        <div
            class="rounded-xl border border-amber-100 bg-amber-50/50 p-3 dark:border-amber-900/30 dark:bg-amber-900/10">
            <p class="text-[10px] uppercase tracking-wider text-amber-600 dark:text-amber-400">Total Selisih</p>
            <p class="mt-1 text-xl font-bold text-amber-700 dark:text-amber-300">
                {{ number_format($totals->total_selisih ?? 0, 2, ',', '.') }}
            </p>
        </div>
        <div
            class="rounded-xl border border-purple-100 bg-purple-50/50 p-3 dark:border-purple-900/30 dark:bg-purple-900/10">
            <p class="text-[10px] uppercase tracking-wider text-purple-600 dark:text-purple-400">Nilai SAP (Rp)</p>
            <p class="mt-1 text-xl font-bold text-purple-700 dark:text-purple-300">
                {{ number_format($totals->total_val_sap ?? 0, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Content: Table + Chart side by side --}}
    <div class="grid gap-6 lg:grid-cols-3">

        {{-- Monthly Table (2/3 width) --}}
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-xl ring-1 ring-zinc-200 dark:ring-zinc-700">
                <table class="w-full table-auto text-left text-sm">
                    <thead
                        class="border-b border-zinc-200 bg-zinc-50/80 text-[10px] uppercase tracking-wider text-zinc-500 dark:border-zinc-700 dark:bg-zinc-800/80 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Bulan</th>
                            <th class="px-4 py-3 text-right font-semibold">Qty SAP</th>
                            <th class="px-4 py-3 text-right font-semibold">Qty Terpasang</th>
                            <th class="px-4 py-3 text-right font-semibold">Selisih</th>
                            <th class="px-4 py-3 text-right font-semibold">Nilai SAP (Rp)</th>
                            <th class="px-4 py-3 text-center font-semibold">Items</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-zinc-700 dark:divide-zinc-700 dark:text-zinc-300">
                        @forelse($monthlyData as $row)
                            <tr class="transition-colors hover:bg-zinc-50/50 dark:hover:bg-zinc-700/30">
                                <td class="px-4 py-2.5 font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $namaBulan[$row->bulan] ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5 text-right font-mono text-xs">
                                    {{ number_format($row->total_qty_sap, 2, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5 text-right font-mono text-xs">
                                    {{ number_format($row->total_qty_installed, 2, ',', '.') }}
                                </td>
                                <td
                                    class="{{ $row->total_selisih > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' }} whitespace-nowrap px-4 py-2.5 text-right font-mono text-xs font-semibold">
                                    {{ number_format($row->total_selisih, 2, ',', '.') }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-2.5 text-right font-mono text-xs font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ number_format($row->total_val_sap, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2.5 text-center">
                                    <span
                                        class="rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-700 dark:bg-blue-900/20 dark:text-blue-400">
                                        {{ $row->total_items }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-zinc-400">
                                    Tidak ada data untuk periode ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($monthlyData->count() > 0)
                        <tfoot
                            class="border-t-2 border-zinc-300 bg-zinc-50 font-semibold dark:border-zinc-600 dark:bg-zinc-800/50">
                            <tr class="text-xs">
                                <td class="px-4 py-2.5 font-bold text-zinc-900 dark:text-zinc-100">TOTAL</td>
                                <td
                                    class="whitespace-nowrap px-4 py-2.5 text-right font-mono text-zinc-900 dark:text-zinc-100">
                                    {{ number_format($monthlyData->sum('total_qty_sap'), 2, ',', '.') }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-2.5 text-right font-mono text-zinc-900 dark:text-zinc-100">
                                    {{ number_format($monthlyData->sum('total_qty_installed'), 2, ',', '.') }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-2.5 text-right font-mono font-bold text-amber-600 dark:text-amber-400">
                                    {{ number_format($monthlyData->sum('total_selisih'), 2, ',', '.') }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-2.5 text-right font-mono text-zinc-900 dark:text-zinc-100">
                                    {{ number_format($monthlyData->sum('total_val_sap'), 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2.5 text-center text-zinc-900 dark:text-zinc-100">
                                    {{ $monthlyData->sum('total_items') }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

        {{-- Age Distribution Chart (1/3 width) --}}
        <div class="flex flex-col">
            <h4 class="mb-3 text-sm font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                Klaster Umur Project
            </h4>
            <div class="flex-1 rounded-xl ring-1 ring-zinc-200 dark:ring-zinc-700" x-data="ageChart({
                labels: ['< 1 Tahun', '1 Tahun', '2 Tahun', '3 Tahun', '4 Tahun', '5+ Tahun'],
                data: @json(array_values($klasterCount)),
                isDark: document.documentElement.classList.contains('dark')
            })">
                <div x-ref="ageChartContainer" class="p-3"></div>
            </div>

            {{-- Legend list --}}
            <div class="mt-3 space-y-1.5">
                @php
                    $klasterLabels = [
                        'kurang_1_tahun' => ['< 1 Tahun', '#10B981'],
                        '1_tahun' => ['1 Tahun', '#3B82F6'],
                        '2_tahun' => ['2 Tahun', '#6366F1'],
                        '3_tahun' => ['3 Tahun', '#F59E0B'],
                        '4_tahun' => ['4 Tahun', '#F97316'],
                        '5_tahun_lebih' => ['5+ Tahun', '#EF4444'],
                    ];
                @endphp
                @foreach ($klasterLabels as $key => [$label, $color])
                    <div
                        class="flex items-center justify-between rounded-lg px-3 py-1.5 text-xs transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-700/30">
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full"
                                style="background-color: {{ $color }}"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">{{ $label }}</span>
                        </div>
                        <span class="font-bold text-zinc-900 dark:text-zinc-100">{{ $klasterCount[$key] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('ageChart', (config) => ({
            chart: null,

            init() {
                this.renderChart(config);

                const observer = new MutationObserver(() => {
                    config.isDark = document.documentElement.classList.contains('dark');
                    this.renderChart(config);
                });
                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            },

            renderChart(config) {
                if (this.chart) {
                    this.chart.destroy();
                }

                var options = {
                    series: config.data,
                    chart: {
                        type: 'donut',
                        height: 280,
                        fontFamily: 'Inter, sans-serif',
                        background: 'transparent',
                    },
                    labels: config.labels,
                    colors: ['#10B981', '#3B82F6', '#6366F1', '#F59E0B', '#F97316', '#EF4444'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        fontWeight: 700,
                                        color: config.isDark ? '#e4e4e7' : '#18181b',
                                        formatter: function(w) {
                                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false
                    },
                    stroke: {
                        width: 2,
                        colors: [config.isDark ? '#27272a' : '#ffffff']
                    },
                    tooltip: {
                        theme: config.isDark ? 'dark' : 'light',
                        y: {
                            formatter: function(val) {
                                return val + ' project';
                            }
                        }
                    },
                    theme: {
                        mode: config.isDark ? 'dark' : 'light'
                    }
                };

                this.chart = new ApexCharts(this.$refs.ageChartContainer, options);
                this.chart.render();
            }
        }));
    </script>
@endscript
