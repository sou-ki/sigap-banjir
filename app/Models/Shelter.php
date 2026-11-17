<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shelter extends Model
{
    protected $fillable = [
        'name', 'address', 'village', 'latitude', 'longitude',
        'capacity', 'occupant_count', 'status', 'notes', 'managed_by',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'managed_by');
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(ShelterFacility::class);
    }

    public function evacuationRequests(): HasMany
    {
        return $this->hasMany(EvacuationRequest::class);
    }

    public function evacuationRoutes(): HasMany
    {
        return $this->hasMany(EvacuationRoute::class);
    }

    public function logisticsNeeds(): HasMany
    {
        return $this->hasMany(LogisticsNeed::class);
    }
}
