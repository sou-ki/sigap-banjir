<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LogisticsNeed extends Model
{
    protected $fillable = [
        'need_number', 'location', 'flood_report_id', 'shelter_id', 'category',
        'item_name', 'quantity_required', 'quantity_allocated', 'unit',
        'urgency', 'people_affected', 'description', 'information_source',
        'status', 'reported_by', 'reviewed_by', 'reported_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity_required' => 'decimal:2',
            'quantity_allocated' => 'decimal:2',
            'reported_at' => 'datetime',
        ];
    }

    public function floodReport(): BelongsTo
    {
        return $this->belongsTo(FloodReport::class);
    }

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(ReliefAllocation::class);
    }
}
