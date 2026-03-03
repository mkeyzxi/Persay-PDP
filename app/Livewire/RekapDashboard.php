<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Projects;
use Illuminate\Support\Facades\DB;

class RekapDashboard extends Component
{
	public $selectedYear;
	public $selectedMonth = '';
	public $availableYears = [];

	public function mount()
	{
		$this->selectedYear = date('Y');

		// Tahun dinamis: dari tahun data project paling lama hingga saat ini
		$earliestYear = Projects::min('fiscal_year') ?? date('Y');
		$currentYear = (int) date('Y');

		for ($y = $earliestYear; $y <= $currentYear; $y++) {
			$this->availableYears[] = $y;
		}
	}

	public function updatedSelectedYear()
	{
		$this->selectedMonth = '';
	}

	public function render()
	{
		// ============================
		// 1. DATA SELISIH & SAP PER BULAN
		// ============================
		$query = DB::table('material_issues_items')
			->join('material_issues', 'material_issues_items.material_issue_id', '=', 'material_issues.id')
			->join('projects', 'material_issues.project_id', '=', 'projects.id')
			->whereYear('material_issues.posting_date', $this->selectedYear);

		if ($this->selectedMonth) {
			$query->whereMonth('material_issues.posting_date', $this->selectedMonth);
		}

		// Ambil ringkasan per bulan
		$monthlyData = DB::table('material_issues_items')
			->join('material_issues', 'material_issues_items.material_issue_id', '=', 'material_issues.id')
			->whereYear('material_issues.posting_date', $this->selectedYear)
			->selectRaw('
                MONTH(material_issues.posting_date) as bulan,
                SUM(material_issues_items.quantity_sap) as total_qty_sap,
                SUM(COALESCE(material_issues_items.quantity_installed, 0)) as total_qty_installed,
                SUM(material_issues_items.quantity_sap - COALESCE(material_issues_items.quantity_installed, 0)) as total_selisih,
                SUM(material_issues_items.val_currency) as total_val_sap,
                COUNT(*) as total_items
            ')
			->groupBy('bulan')
			->orderBy('bulan')
			->get();

		// Totals (filtered by month if selected)
		$totals = (clone $query)->selectRaw('
            SUM(material_issues_items.quantity_sap) as total_qty_sap,
            SUM(COALESCE(material_issues_items.quantity_installed, 0)) as total_qty_installed,
            SUM(material_issues_items.quantity_sap - COALESCE(material_issues_items.quantity_installed, 0)) as total_selisih,
            SUM(material_issues_items.val_currency) as total_val_sap,
            COUNT(*) as total_items
        ')->first();

		// ============================
		// 2. KLASTER UMUR PROJECT
		// ============================
		$now = Carbon::now();

		$projects = Projects::whereNotNull('contract_start_date')->get();

		$klasterCount = [
			'kurang_1_tahun' => 0,
			'1_tahun' => 0,
			'2_tahun' => 0,
			'3_tahun' => 0,
			'4_tahun' => 0,
			'5_tahun_lebih' => 0,
		];

		foreach ($projects as $p) {
			$start = Carbon::parse($p->contract_start_date);
			$diffYears = $start->diffInYears($now);

			if ($diffYears < 1) {
				$klasterCount['kurang_1_tahun']++;
			} elseif ($diffYears < 2) {
				$klasterCount['1_tahun']++;
			} elseif ($diffYears < 3) {
				$klasterCount['2_tahun']++;
			} elseif ($diffYears < 4) {
				$klasterCount['3_tahun']++;
			} elseif ($diffYears < 5) {
				$klasterCount['4_tahun']++;
			} else {
				$klasterCount['5_tahun_lebih']++;
			}
		}

		// Nama bulan Indonesia
		$namaBulan = [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember',
		];

		return view('livewire.rekap-dashboard', [
			'monthlyData' => $monthlyData,
			'totals' => $totals,
			'klasterCount' => $klasterCount,
			'namaBulan' => $namaBulan,
		]);
	}
}
