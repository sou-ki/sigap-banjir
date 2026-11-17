<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvacuationRoute extends Model
{
    protected $fillable = [
        'name', 'origin_name', 'origin_latitude', 'origin_longitude',
        'shelter_id', 'destination_name', 'destination_latitude',
        'destination_longitude', 'route_coordinates', 'distance_km',
        'estimated_minutes', 'status', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'origin_latitude' => 'decimal:7',
            'origin_longitude' => 'decimal:7',
            'destination_latitude' => 'decimal:7',
            'destination_longitude' => 'decimal:7',
            'distance_km' => 'decimal:2',
            'route_coordinates' => 'array',
        ];
    }

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
