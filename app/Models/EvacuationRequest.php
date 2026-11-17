<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class EvacuationRequest extends Model
{
    protected $fillable = [
        'request_number', 'user_id', 'flood_report_id', 'requester_name', 'contact_phone',
        'pickup_address', 'village', 'latitude', 'longitude', 'people_count',
        'emergency_condition', 'vulnerable_groups', 'additional_information',
        'public_note', 'priority', 'status', 'handled_by', 'shelter_id', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'vulnerable_groups' => 'array',
            'completed_at' => 'datetime',
        ];
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }

    public function floodReport(): BelongsTo
    {
        return $this->belongsTo(FloodReport::class);
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'subject')->orderBy('created_at');
    }
}
