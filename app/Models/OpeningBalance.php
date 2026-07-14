<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class OpeningBalance extends Model
{
	protected $fillable = [
		'amount',
		'period_start',
		'period_end',
		'description',
		'created_by',
	];

	protected $casts = [
		'amount' => 'decimal:2',
		'period_start' => 'date',
		'period_end' => 'date',
	];

	/**
	 * Relasi ke user pembuat
	 */
	public function createdBy(): BelongsTo
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	/**
	 * Scope: saldo yang sedang aktif (berlaku hari ini)
	 */
	public function scopeActive($query)
	{
		$today = Carbon::today();
		return $query->where('period_start', '<=', $today)
			->where('period_end', '>=', $today);
	}

	/**
	 * Mendapatkan saldo aktif saat ini
	 */
	public static function getActiveBalance(): ?self
	{
		return static::active()->first();
	}

	/**
	 * Mendapatkan saldo aktif untuk tanggal tertentu
	 */
	public static function getBalanceForDate($date): ?self
	{
		$date = Carbon::parse($date);
		return static::where('period_start', '<=', $date)
			->where('period_end', '>=', $date)
			->first();
	}

	/**
	 * Hitung sisa saldo = amount - SUM(contract_value) dari project
	 * yang contract_start_date-nya berada dalam periode saldo ini
	 */
	public function getRemainingBalance(): float
	{
		$totalContractValue = Projects::where(function ($query) {
			$query->whereBetween('contract_start_date', [$this->period_start, $this->period_end])
				->orWhere(function ($q) {
					// Project yang masih aktif di periode ini
					$q->where('contract_start_date', '<=', $this->period_end)
						->where(function ($inner) {
							$inner->whereNull('contract_end_date')
								->orWhere('contract_end_date', '>=', $this->period_start);
						});
				});
		})->sum('contract_value');

		return (float) $this->amount - (float) $totalContractValue;
	}

	/**
	 * Hitung sisa saldo sampai tanggal tertentu
	 * Hanya menghitung project yang contract_start_date <= $upToDate
	 */
	public function getRemainingBalanceUpTo($upToDate): float
	{
		$upToDate = Carbon::parse($upToDate);
		$periodStart = $this->period_start;

		$totalContractValue = Projects::where(function ($query) use ($upToDate, $periodStart) {
			$query->where('contract_start_date', '<=', $upToDate)
				->where(function ($q) use ($upToDate, $periodStart) {
					$q->where('contract_start_date', '>=', $periodStart)
						->orWhere(function ($inner) use ($periodStart) {
							$inner->where('contract_start_date', '<=', $periodStart)
								->where(function ($i) use ($periodStart) {
									$i->whereNull('contract_end_date')
										->orWhere('contract_end_date', '>=', $periodStart);
								});
						});
				});
		})->sum('contract_value');

		return (float) $this->amount - (float) $totalContractValue;
	}

	/**
	 * Status saldo: Aktif, Kadaluarsa, atau Belum Aktif
	 */
	public function getStatusAttribute(): string
	{
		$today = Carbon::today();

		if ($today->lt($this->period_start)) {
			return 'Belum Aktif';
		}

		if ($today->gt($this->period_end)) {
			return 'Kadaluarsa';
		}

		return 'Aktif';
	}
}
