<div class="flex flex-col gap-6 rounded-xl bg-white p-5 shadow-sm dark:bg-zinc-800">

    {{-- Header --}}
    <div class="border-b border-zinc-200 pb-4 dark:border-zinc-700">
        <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">
            Saldo Awal
        </h3>
        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
            Perbandingan saldo awal, dana terpakai, dan sisa saldo per periode
        </p>
    </div>

    {{-- Summary Cards for Active Balance --}}
    @if ($activeBalance)
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <div
                class="rounded-xl border border-emerald-100 bg-emerald-50/50 p-4 dark:border-emerald-900/30 dark:bg-emerald-900/10">
                <p class="text-[10px] uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Saldo Awal (Aktif)
                </p>
                <p class="mt-1 text-xl font-bold text-emerald-700 dark:text-emerald-300">
                    Rp {{ number_format($activeBalance->amount, 0, ',', '.') }}
                </p>
                <p class="mt-1 text-[10px] text-emerald-500 dark:text-emerald-500">
                    {{ $activeBalance->period_start->format('d M Y') }} —
                    {{ $activeBalance->period_end->format('d M Y') }}
                </p>
            </div>
            <div
                class="rounded-xl border border-amber-100 bg-amber-50/50 p-4 dark:border-amber-900/30 dark:bg-amber-900/10">
                <p class="text-[10px] uppercase tracking-wider text-amber-600 dark:text-amber-400">Dana Terpakai</p>
                <p class="mt-1 text-xl font-bold text-amber-700 dark:text-amber-300">
                    Rp {{ number_format($activeTerpakai, 0, ',', '.') }}
                </p>
                <p class="mt-1 text-[10px] text-amber-500 dark:text-amber-500">
                    {{ $activeBalance->amount > 0 ? number_format(($activeTerpakai / $activeBalance->amount) * 100, 1) : 0 }}%
                    dari saldo awal
                </p>
            </div>
            <div
                class="rounded-xl border border-indigo-100 bg-indigo-50/50 p-4 dark:border-indigo-900/30 dark:bg-indigo-900/10">
                <p class="text-[10px] uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Sisa Saldo</p>
                <p
                    class="{{ $activeRemaining >= 0 ? 'text-indigo-700 dark:text-indigo-300' : 'text-red-600 dark:text-red-400' }} mt-1 text-xl font-bold">
                    Rp {{ number_format($activeRemaining, 0, ',', '.') }}
                </p>
                <p
                    class="{{ $activeRemaining >= 0 ? 'text-indigo-500 dark:text-indigo-500' : 'text-red-400 dark:text-red-500' }} mt-1 text-[10px]">
                    {{ $activeBalance->amount > 0 ? number_format(($activeRemaining / $activeBalance->amount) * 100, 1) : 0 }}%
                    tersisa
                </p>
            </div>
        </div>
    @else
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-800 dark:bg-amber-900/20">
            <p class="text-sm text-amber-700 dark:text-amber-300">
                Belum ada saldo awal yang aktif untuk periode saat ini.
            </p>
        </div>
    @endif

    {{-- Bar Chart --}}
    @if (count($chartLabels) > 0)
        <script type="application/json" id="saldo-awal-chart-data">
            {!! json_encode(['labels' => $chartLabels, 'saldoAwal' => $chartSaldoAwal, 'terpakai' => $chartTerpakai, 'sisaSaldo' => $chartSisaSaldo]) !!}
        </script>
        <div class="rounded-xl ring-1 ring-zinc-200 dark:ring-zinc-700" x-data="saldoAwalChart()" x-init="initFromJson()">
            <div x-ref="saldoChartContainer" class="p-3"></div>
        </div>
    @else
        <div class="py-8 text-center text-zinc-400 dark:text-zinc-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <p class="mt-2 text-sm">Belum ada data saldo awal</p>
        </div>
    @endif
</div>

@script
    <script>
        Alpine.data('saldoAwalChart', () => ({
            chart: null,
            config: {},

            initFromJson() {
                const el = document.getElementById('saldo-awal-chart-data');
                if (!el) return;

                const data = JSON.parse(el.textContent);
                this.config = {
                    labels: data.labels,
                    saldoAwal: data.saldoAwal,
                    terpakai: data.terpakai,
                    sisaSaldo: data.sisaSaldo,
                    isDark: document.documentElement.classList.contains('dark')
                };

                this.renderChart();

                const observer = new MutationObserver(() => {
                    this.config.isDark = document.documentElement.classList.contains('dark');
                    this.renderChart();
                });
                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            },

            renderChart() {
                if (this.chart) {
                    this.chart.destroy();
                }

                const isDark = this.config.isDark;
                const textColor = isDark ? '#a1a1aa' : '#71717a';
                const gridColor = isDark ? '#3f3f46' : '#e4e4e7';

                var options = {
                    series: [{
                            name: 'Saldo Awal',
                            data: this.config.saldoAwal
                        },
                        {
                            name: 'Dana Terpakai',
                            data: this.config.terpakai
                        },
                        {
                            name: 'Sisa Saldo',
                            data: this.config.sisaSaldo
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 350,
                        fontFamily: 'Inter, sans-serif',
                        background: 'transparent',
                        toolbar: {
                            show: false
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '65%',
                            borderRadius: 6,
                            borderRadiusApplication: 'end',
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: this.config.labels,
                        labels: {
                            style: {
                                colors: textColor,
                                fontSize: '11px',
                            },
                            rotate: -30,
                            trim: true,
                            maxHeight: 80,
                        },
                        axisBorder: {
                            color: gridColor
                        },
                        axisTicks: {
                            color: gridColor
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: textColor,
                                fontSize: '11px',
                            },
                            formatter: function(val) {
                                if (val >= 1000000000) {
                                    return 'Rp ' + (val / 1000000000).toFixed(1) + ' M';
                                } else if (val >= 1000000) {
                                    return 'Rp ' + (val / 1000000).toFixed(1) + ' Jt';
                                } else if (val >= 1000) {
                                    return 'Rp ' + (val / 1000).toFixed(0) + ' Rb';
                                }
                                return 'Rp ' + val;
                            }
                        }
                    },
                    colors: ['#10B981', '#F59E0B', '#6366F1'],
                    fill: {
                        opacity: 1,
                        type: 'gradient',
                        gradient: {
                            shade: isDark ? 'dark' : 'light',
                            type: 'vertical',
                            shadeIntensity: 0.2,
                            opacityFrom: 1,
                            opacityTo: 0.85,
                        }
                    },
                    grid: {
                        borderColor: gridColor,
                        strokeDashArray: 4,
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        y: {
                            formatter: function(val) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        labels: {
                            colors: textColor
                        },
                        markers: {
                            size: 5,
                            shape: 'circle',
                        },
                        fontSize: '12px',
                        fontWeight: 600,
                        itemMargin: {
                            horizontal: 12
                        }
                    },
                    theme: {
                        mode: isDark ? 'dark' : 'light'
                    }
                };

                this.chart = new ApexCharts(this.$refs.saldoChartContainer, options);
                this.chart.render();
            }
        }));
    </script>
@endscript
