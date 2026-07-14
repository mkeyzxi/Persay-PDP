<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialIssuesItems extends Model
{
    
    use HasFactory;
protected $fillable = [
        'material_issue_id',
        'material_id',
        'quantity_sap',
        'val_currency',
        'wbs_element',
        'quantity_installed',
        'asset_number',
  'asset_number_date',
        'remarks',
    ];

    protected $casts = [
        'quantity_sap' => 'decimal:2',
        'val_currency' => 'decimal:2',
        'quantity_installed' => 'decimal:2',
    ];

    public function materialIssue(): BelongsTo
    {
        return $this->belongsTo(MaterialIssues::class, 'material_issue_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    public function issue()
    {
        return $this->belongsTo(
            MaterialIssues::class,
            'material_issue_id'
        );
    }
}
