<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Projects;
use Illuminate\Support\Facades\DB;

class GrafikProject extends Component
{
    public $year;

    public function mount()
    {
        $this->year = date('Y');
    }

    public function render()
    {
        // 1. Tentukan Range Tanggal (1 Jan - Hari Ini)
        $startDate = Carbon::createFromDate($this->year, 1, 1)->startOfDay();

        // Batas akhir: Jika tahun ini -> Pakai NOW(), Jika tahun lalu -> 31 Des
        $endDate = ($this->year == date('Y'))
            ? Carbon::now()
            : Carbon::createFromDate($this->year, 12, 31)->endOfDay();

        // 2. Hitung Saldo Awal Tahun (Global)
        // Ambil Total Nilai Kontrak Semua Proyek
        $totalBudget = Projects::sum('contract_value') ?? 0;

        // Hitung pengeluaran tahun-tahun sebelumnya (Dosa Masa Lalu)
        $previousYearsExpense = DB::table('material_issues_items')
            ->join('material_issues', 'material_issues_items.material_issue_id', '=', 'material_issues.id')
            ->where('material_issues.posting_date', '<', $startDate)
            ->sum('material_issues_items.val_currency');

        // Saldo Start di tanggal 1 Jan
        $currentBalance = $totalBudget - $previousYearsExpense;

        // 3. Ambil Transaksi Harian dalam Range Tanggal
        $dailyTransactions = DB::table('material_issues_items')
            ->join('material_issues', 'material_issues_items.material_issue_id', '=', 'material_issues.id')
            ->whereBetween('material_issues.posting_date', [$startDate, $endDate])
            ->selectRaw('DATE(material_issues.posting_date) as date, SUM(material_issues_items.val_currency) as total_expense')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total_expense', 'date')
            ->toArray();

        // 4. Loop Harian untuk TimeSeries (Agar grafik nyambung)
        $chartData = [];
        $tempDate = $startDate->copy();

        while ($tempDate->lte($endDate)) {
            $dateString = $tempDate->format('Y-m-d');
            // Timestamp JS butuh milidetik (*1000)
            $timestamp = $tempDate->timestamp * 1000;

            // Cek apakah ada pengeluaran hari itu
            $expenseToday = $dailyTransactions[$dateString] ?? 0;

            // Kurangi saldo berjalan
            $currentBalance -= $expenseToday;

            // Masukkan ke array [x, y] untuk ApexCharts
            $chartData[] = [$timestamp, $currentBalance];

            $tempDate->addDay();
        }

        return view('livewire.grafik-project', [
            'seriesData' => $chartData,
            'totalBudget' => $totalBudget
        ]);
    }
}
