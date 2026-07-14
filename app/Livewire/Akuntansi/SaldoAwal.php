<?php

namespace App\Livewire\Akuntansi;

use Livewire\Component;
use App\Models\OpeningBalance;
use App\Models\Projects;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SaldoAwal extends Component
{
	// Form fields
	public $amount = '';
	public $period_start = '';
	public $period_end = '';
	public $description = '';

	// Edit mode
	public $editingId = null;
	public $isEditing = false;

	// Delete confirmation
	public $confirmingDeleteId = null;

	// Filter properties
	public $filterYear;
	public $filterMonth = null;

	/**
	 * Mount component
	 */
	public function mount()
	{
		$this->filterYear = date('Y');
	}

	/**
	 * Validation rules
	 */
	protected function rules()
	{
		return [
			'amount' => 'required|numeric|min:0',
			'period_start' => 'required|date',
			'period_end' => 'required|date|after:period_start',
			'description' => 'nullable|string|max:1000',
		];
	}

	protected $messages = [
		'amount.required' => 'Jumlah saldo awal wajib diisi.',
		'amount.numeric' => 'Jumlah saldo harus berupa angka.',
		'amount.min' => 'Jumlah saldo tidak boleh kurang dari 0.',
		'period_start.required' => 'Tanggal mulai wajib diisi.',
		'period_start.date' => 'Format tanggal mulai tidak valid.',
		'period_end.required' => 'Tanggal akhir wajib diisi.',
		'period_end.date' => 'Format tanggal akhir tidak valid.',
		'period_end.after' => 'Tanggal akhir harus setelah tanggal mulai.',
	];

	/**
	 * Simpan saldo awal baru
	 */
	public function save()
	{
		$this->validate();

		// Cek overlap periode
		$overlap = OpeningBalance::where(function ($query) {
			$query->where(function ($q) {
				$q->where('period_start', '<=', $this->period_end)
					->where('period_end', '>=', $this->period_start);
			});
		});

		if ($this->editingId) {
			$overlap->where('id', '!=', $this->editingId);
		}

		if ($overlap->exists()) {
			session()->flash('error', 'Periode saldo awal bertabrakan dengan saldo awal yang sudah ada.');
			return;
		}

		if ($this->editingId) {
			// Update
			$balance = OpeningBalance::findOrFail($this->editingId);
			$balance->update([
				'amount' => $this->amount,
				'period_start' => $this->period_start,
				'period_end' => $this->period_end,
				'description' => $this->description,
			]);
			session()->flash('success', 'Saldo awal berhasil diperbarui.');
		} else {
			// Create
			OpeningBalance::create([
				'amount' => $this->amount,
				'period_start' => $this->period_start,
				'period_end' => $this->period_end,
				'description' => $this->description,
				'created_by' => Auth::id(),
			]);
			session()->flash('success', 'Saldo awal berhasil ditambahkan.');
		}

		$this->resetForm();
	}

	/**
	 * Edit saldo awal
	 */
	public function edit($id)
	{
		$balance = OpeningBalance::findOrFail($id);

		$this->editingId = $balance->id;
		$this->isEditing = true;
		$this->amount = $balance->amount;
		$this->period_start = $balance->period_start->format('Y-m-d');
		$this->period_end = $balance->period_end->format('Y-m-d');
		$this->description = $balance->description;
	}

	/**
	 * Konfirmasi hapus
	 */
	public function confirmDelete($id)
	{
		$this->confirmingDeleteId = $id;
	}

	/**
	 * Batalkan hapus
	 */
	public function cancelDelete()
	{
		$this->confirmingDeleteId = null;
	}

	/**
	 * Hapus saldo awal
	 */
	public function delete($id)
	{
		OpeningBalance::findOrFail($id)->delete();
		$this->confirmingDeleteId = null;
		session()->flash('success', 'Saldo awal berhasil dihapus.');
	}

	/**
	 * Reset form
	 */
	public function resetForm()
	{
		$this->reset(['amount', 'period_start', 'period_end', 'description', 'editingId', 'isEditing']);
		$this->resetValidation();
	}

	/**
	 * Render view
	 */
	/**
	 * Generate monthly breakdown for the selected year
	 */
	public function getMonthlyBreakdown()
	{
		$year = $this->filterYear;
		$months = [];
		$monthNames = [
			1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
			5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
			9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
		];

		// Find the active balance that covers this year
		$yearStart = Carbon::create($year, 1, 1);
		$yearEnd = Carbon::create($year, 12, 31);

		$balance = OpeningBalance::where('period_start', '<=', $yearEnd)
			->where('period_end', '>=', $yearStart)
			->first();

		if (!$balance) {
			return collect();
		}

		$saldoAwal = (float) $balance->amount;

		foreach ($monthNames as $monthNum => $monthName) {
			$monthStart = Carbon::create($year, $monthNum, 1);
			$monthEnd = $monthStart->copy()->endOfMonth();

			// Skip months outside the balance period
			if ($monthEnd->lt($balance->period_start) || $monthStart->gt($balance->period_end)) {
				continue;
			}

			// Contract value added in this specific month
			$monthlyContractValue = Projects::whereBetween('contract_start_date', [$monthStart, $monthEnd])
				->sum('contract_value');

			// Accumulated contract value up to end of this month
			$accumulatedValue = Projects::where('contract_start_date', '<=', $monthEnd)
				->where('contract_start_date', '>=', $balance->period_start)
				->sum('contract_value');

			$sisaSaldo = $saldoAwal - (float) $accumulatedValue;
			$percentage = $saldoAwal > 0 ? min(100, round(((float) $accumulatedValue / $saldoAwal) * 100, 1)) : 0;

			$months[] = [
				'month' => $monthNum,
				'name' => $monthName,
				'monthly_value' => (float) $monthlyContractValue,
				'accumulated_value' => (float) $accumulatedValue,
				'remaining' => $sisaSaldo,
				'percentage' => $percentage,
				'saldo_awal' => $saldoAwal,
			];
		}

		return collect($months);
	}

	public function render()
	{
		$balances = OpeningBalance::orderBy('period_start', 'desc')->get();

		// Hitung sisa saldo untuk setiap balance
		$balancesWithRemaining = $balances->map(function ($balance) {
			$balance->remaining = $balance->getRemainingBalance();
			return $balance;
		});

		$activeBalance = OpeningBalance::getActiveBalance();
		if ($activeBalance) {
			$activeBalance->remaining = $activeBalance->getRemainingBalance();
		}

		// Monthly breakdown
		$monthlyBreakdown = $this->getMonthlyBreakdown();

		// Available years for filter
		$availableYears = OpeningBalance::selectRaw('YEAR(period_start) as year')
			->union(OpeningBalance::selectRaw('YEAR(period_end) as year'))
			->distinct()
			->pluck('year')
			->sort()
			->values();

		if ($availableYears->isEmpty()) {
			$availableYears = collect([date('Y')]);
		}

		return view('livewire.akuntansi.saldo-awal', [
			'balances' => $balancesWithRemaining,
			'activeBalance' => $activeBalance,
			'monthlyBreakdown' => $monthlyBreakdown,
			'availableYears' => $availableYears,
		]);
	}
}
