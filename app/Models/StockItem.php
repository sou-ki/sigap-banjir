<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockItem extends Model
{
    protected $fillable = [
        'item_code', 'name', 'category', 'quantity', 'unit', 'source',
        'storage_location', 'received_at', 'expires_at', 'condition',
        'responsible_user_id', 'contributed_by',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'received_at' => 'date',
            'expires_at' => 'date',
        ];
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function contributor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contributed_by');
    }

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(ReliefAllocation::class);
    }
}
