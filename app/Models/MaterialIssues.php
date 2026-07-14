<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialIssues extends Model
{
    
    use HasFactory;
protected $fillable = [
        'project_id',
        'sap_doc_no',
        'posting_date',
        'header_text',
        'created_by',
    ];

    protected $casts = [
        'posting_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MaterialIssuesItems::class, 'material_issue_id');
    }
}

