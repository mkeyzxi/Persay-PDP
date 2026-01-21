<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
