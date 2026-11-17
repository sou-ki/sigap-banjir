<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReliefAllocation extends Model
{
    protected $fillable = [
        'allocation_number', 'stock_item_id', 'logistics_need_id', 'shelter_id',
        'quantity', 'status', 'allocated_by', 'approved_by', 'approved_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'approved_at' => 'datetime',
        ];
    }

    public function stockItem(): BelongsTo
    {
        return $this->belongsTo(StockItem::class);
    }

    public function logisticsNeed(): BelongsTo
    {
        return $this->belongsTo(LogisticsNeed::class);
    }

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }

    public function allocator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(ReliefDistribution::class);
    }
}
