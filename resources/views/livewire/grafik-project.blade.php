{{--
GRAFIK PROJECT - DIKOMENTARI SEMENTARA
Diganti dengan komponen rekap-dashboard

<div class="flex h-full flex-col rounded-xl bg-white p-4 shadow-sm dark:bg-zinc-800">
    <div class="mb-4 flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-700">
        <div>
            <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">
                Arus Kas Global (Realtime)
            </h3>
            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                Total Nilai Kontrak (Pagu):
                <span class="font-bold text-emerald-600 dark:text-emerald-400">
                    Rp {{ number_format($totalBudget, 0, ',', '.') }}
                </span>
            </p>
        </div>

        <select wire:model.live="year"
            class="focus:ring-primary-500 rounded-lg border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm font-medium focus:ring-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100">
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
        </select>
    </div>

    <div class="relative min-h-[350px] w-full flex-1" x-data="financeChart({
        series: @json($seriesData),
        isDark: document.documentElement.classList.contains('dark')
    })">
        <div x-ref="chartContainer"></div>
    </div>
</div>

@script
    <script>
        Alpine.data('financeChart', (config) => ({
            chart: null,

            init() {
                this.renderChart(config.series, config.isDark);

                // Watch for dark mode changes
                const observer = new MutationObserver(() => {
                    const isDark = document.documentElement.classList.contains('dark');
                    this.renderChart(config.series, isDark);
                });
                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            },

            renderChart(seriesData, isDark) {
                if (this.chart) {
                    this.chart.destroy();
                }

                var options = {
                    series: [{
                        name: 'Sisa Saldo',
                        data: seriesData
                    }],
                    chart: {
                        type: 'area',
                        height: 350,
                        fontFamily: 'Inter, sans-serif',
                        background: 'transparent',
                        animations: {
                            enabled: true
                        },
                        zoom: {
                            type: 'x',
                            enabled: true,
                            autoScaleYaxis: true
                        },
                        toolbar: {
                            autoSelected: 'zoom',
                            tools: {
                                download: false
                            }
                        }
                    },
                    colors: ['#10B981'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0.05,
                            stops: [0, 100]
                        }
                    },
                    xaxis: {
                        type: 'datetime',
                        tooltip: {
                            enabled: false
                        },
                        labels: {
                            style: {
                                colors: isDark ? '#a1a1aa' : '#52525b'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: isDark ? '#a1a1aa' : '#52525b'
                            },
                            formatter: (val) => {
                                return (val / 1000000).toFixed(1) + ' Jt'
                            }
                        },
                    },
                    theme: {
                        mode: isDark ? 'dark' : 'light'
                    },
                    grid: {
                        borderColor: isDark ? '#3f3f46' : '#e4e4e7',
                        strokeDashArray: 4,
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        x: {
                            format: 'dd MMM yyyy'
                        },
                        y: {
                            formatter: function(val) {
                                return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            }
                        }
                    }
                };

                this.chart = new ApexCharts(this.$refs.chartContainer, options);
                this.chart.render();
            }
        }));
    </script>
@endscript
--}}
