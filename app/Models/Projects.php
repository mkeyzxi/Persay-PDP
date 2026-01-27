<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Projects extends Model
{
    protected $fillable = [
        'spk_number',
        'wbs_number',
        'project_name',
        'vendor_name',
        'location',
        'contract_value',
        'contract_start_date',
        'contract_end_date',
        'bastp_date',
        'slo_date',
        'unit_code',
        'fiscal_year',
        'proggress_percent',
        'category',
        'pdp_category',
        'follow_up_code',
        'constraint_note',
        'status',
        'created_by',
        'target_completion_date',
'contract_number',
    ];

    protected $casts = [
        'contract_value' => 'decimal:2',
        'proggress_percent' => 'integer',
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'bastp_date' => 'date',
        'slo_date' => 'date',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function wbsLogs(): HasMany
    {
        return $this->hasMany(ProjectWbsLog::class, 'project_id');
    }

    public function materialIssues(): HasMany
    {
        return $this->hasMany(MaterialIssues::class, 'project_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProjectDocuments::class, 'project_id');
    }

    public function scopeSearch($projects, $search)
    {
        if (!$search) return $projects;

        return $projects->where(function ($q) use ($search) {
            $q->where('spk_number', 'like', "%{$search}%")
                ->orWhere('project_name', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
        });
    }
    public function scopeSortContractDate($projects, $sortFieldContract)
    {
        if (!$sortFieldContract) return $projects;

        return $projects->orderBy('contract_end_date', $sortFieldContract);
    }
 public function scopeSortContractValue($projects, $sortFieldBalance)
    {
        if (!$sortFieldBalance) return $projects;

        return $projects->orderBy('contract_end_date', $sortFieldBalance);
    }
//Cjart
public static function getGlobalTrend($year)
{
    // 1. Ambil TOTAL Nilai Kontrak dari SEMUA Proyek (Pagu Perusahaan)
    // Opsional: Filter hanya proyek yang statusnya OPEN/CLOSED tahun ini
    $totalBudget = self::sum('contract_value') ?? 0;

    // 2. Ambil SEMUA Pengeluaran Material dari SEMUA Proyek
    // Hapus baris ->where('material_issues.project_id', $this->id)
    $monthlyExpenses = DB::table('material_issues_items')
        ->join('material_issues', 'material_issues_items.material_issue_id', '=', 'material_issues.id')
        ->whereYear('material_issues.posting_date', $year) // Hanya tahun berjalan
        ->selectRaw('MONTH(material_issues.posting_date) as month, SUM(material_issues_items.val_currency) as total')
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();

    $trendData = [];
    $cumulativeExpense = 0;

    // Logic untuk menghitung "Dosa Masa Lalu" (Pengeluaran tahun-tahun sebelumnya)
    // Agar saldo awal Januari benar
    $previousYearsExpense = DB::table('material_issues_items')
        ->join('material_issues', 'material_issues_items.material_issue_id', '=', 'material_issues.id')
        ->whereYear('material_issues.posting_date', '<', $year)
        ->sum('material_issues_items.val_currency');

    $cumulativeExpense = $previousYearsExpense;

    $indoMonths = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    for ($i = 1; $i <= 12; $i++) {
        $expenseThisMonth = $monthlyExpenses[$i] ?? 0;
        $cumulativeExpense += $expenseThisMonth;

        // Sisa Saldo Global (Total Pagu Semua Proyek - Total Pengeluaran Semua Proyek)
        $currentBalance = $totalBudget - $cumulativeExpense;

        $trendData[] = [
            'month_name' => $indoMonths[$i],
            'expense' => $expenseThisMonth,
            'cumulative_expense' => $cumulativeExpense,
            'remaining_balance' => $currentBalance
        ];
    }

    return [
        'total_budget' => $totalBudget,
        'trend' => $trendData
    ];
}

}
