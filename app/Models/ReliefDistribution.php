<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReliefDistribution extends Model
{
    protected $fillable = [
        'distribution_number', 'relief_allocation_id', 'origin', 'destination',
        'quantity_sent', 'quantity_received', 'responsible_team', 'status',
        'prepared_by', 'confirmed_by', 'shipped_at', 'received_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity_sent' => 'decimal:2',
            'quantity_received' => 'decimal:2',
            'shipped_at' => 'datetime',
            'received_at' => 'datetime',
        ];
    }

    public function allocation(): BelongsTo
    {
        return $this->belongsTo(ReliefAllocation::class, 'relief_allocation_id');
    }

    public function preparer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function confirmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}
