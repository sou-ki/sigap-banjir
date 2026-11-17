<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoadCondition extends Model
{
    protected $fillable = ['road_name', 'access_status', 'notes', 'coordinates', 'reported_by', 'observed_at'];

    protected function casts(): array
    {
        return [
            'coordinates' => 'array',
            'observed_at' => 'datetime',
        ];
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
