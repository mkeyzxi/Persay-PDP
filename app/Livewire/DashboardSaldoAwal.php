<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OpeningBalance;

class DashboardSaldoAwal extends Component
{
	public function render()
	{
		$balances = OpeningBalance::orderBy('period_start', 'asc')->get();

		// Siapkan data chart
		$chartLabels = [];
		$chartSaldoAwal = [];
		$chartTerpakai = [];
		$chartSisaSaldo = [];

		foreach ($balances as $balance) {
			$remaining = $balance->getRemainingBalance();
			$terpakai = (float) $balance->amount - $remaining;

			$chartLabels[] = $balance->period_start->format('d M Y') . ' - ' . $balance->period_end->format('d M Y');
			$chartSaldoAwal[] = round((float) $balance->amount, 2);
			$chartTerpakai[] = round($terpakai, 2);
			$chartSisaSaldo[] = round($remaining, 2);
		}

		// Active balance untuk summary cards
		$activeBalance = OpeningBalance::getActiveBalance();
		$activeRemaining = $activeBalance ? $activeBalance->getRemainingBalance() : 0;
		$activeTerpakai = $activeBalance ? ((float) $activeBalance->amount - $activeRemaining) : 0;

		return view('livewire.dashboard-saldo-awal', [
			'chartLabels' => $chartLabels,
			'chartSaldoAwal' => $chartSaldoAwal,
			'chartTerpakai' => $chartTerpakai,
			'chartSisaSaldo' => $chartSisaSaldo,
			'activeBalance' => $activeBalance,
			'activeRemaining' => $activeRemaining,
			'activeTerpakai' => $activeTerpakai,
		]);
	}
}
