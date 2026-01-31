<div class="flex h-full flex-col rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
    <div class="mb-4 flex items-center justify-between border-b pb-4 dark:border-gray-700">
        <div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                Arus Kas Global (Realtime)
            </h3>
            <p class="mt-1 text-xs text-gray-500">
                Total Nilai Kontrak (Pagu):
                <span class="font-bold text-emerald-600">
                    Rp {{ number_format($totalBudget, 0, ',', '.') }}
                </span>
            </p>
        </div>

        <select wire:model.live="year"
            class="rounded-lg border bg-gray-50 px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
        </select>
    </div>

    <div class="relative min-h-[350px] w-full flex-1" x-data="financeChart({
        series: @json($seriesData)
    })">
        <div x-ref="chartContainer"></div>
    </div>
</div>

@script
    <script>
        Alpine.data('financeChart', (config) => ({
            chart: null,

            init() {
                // Render chart saat komponen dimuat pertama kali
                this.renderChart(config.series);

                // Watcher: Jika data dari Livewire berubah (misal ganti tahun),
                // render ulang chart dengan data baru.
                this.$watch('config.series', (value) => {
                    // Di sini kita tidak perlu manual watch sebenarnya karena
                    // Livewire akan me-refresh komponen HTML ini,
                    // yang memicu init() jalan ulang.
                });
            },

            renderChart(seriesData) {
                // Hapus chart lama agar tidak menumpuk/memory leak
                if (this.chart) {
                    this.chart.destroy();
                }

                // Konfigurasi ApexCharts
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
                    colors: ['#10B981'], // Warna Emerald/Hijau
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
                        type: 'datetime', // Kunci agar Zoomable TimeSeries jalan
                        tooltip: {
                            enabled: false
                        },
                        labels: {
                            style: {
                                colors: '#64748b'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#64748b'
                            },
                            // Formatter Jutaan (Jt)
                            formatter: (val) => {
                                return (val / 1000000).toFixed(1) + ' Jt'
                            }
                        },
                    },
                    theme: {
                        mode: 'light' // Bisa diganti 'dark' sesuai tema
                    },
                    grid: {
                        borderColor: '#f1f5f9',
                        strokeDashArray: 4,
                    },
                    tooltip: {
                        theme: 'dark',
                        x: {
                            format: 'dd MMM yyyy'
                        },
                        y: {
                            formatter: function(val) {
                                // Format Rupiah Penuh: Rp 10.000.000
                                return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            }
                        }
                    }
                };

                // Inisialisasi Chart ke elemen div x-ref="chartContainer"
                this.chart = new ApexCharts(this.$refs.chartContainer, options);
                this.chart.render();
            }
        }));
    </script>
@endscript
