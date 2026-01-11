<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectWbsLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'wbs_number',
        'set_by',
        'set_at',
    ];

    protected $casts = [
        'set_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function setByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'set_by');
    }
}

