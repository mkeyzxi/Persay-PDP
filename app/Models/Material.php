<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    
    use HasFactory;
protected $fillable = [
        'sap_material_code',
        'material_description',
        'uom',
        'category',
    ];

    public function issueItems(): HasMany
    {
        return $this->hasMany(MaterialIssuesItems::class, 'material_id');
    }
}

