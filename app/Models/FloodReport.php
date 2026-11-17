<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class FloodReport extends Model
{
    protected $fillable = [
        'report_number', 'user_id', 'reporter_name', 'contact_phone', 'title', 'description', 'occurred_at',
        'village', 'address', 'latitude', 'longitude', 'water_level_cm', 'flow_condition',
        'danger_level', 'impacts', 'status', 'verified_by', 'verified_at',
        'verification_note',
    ];

    protected function casts(): array
    {
        return [
            'occurred_at' => 'datetime',
            'verified_at' => 'datetime',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'impacts' => 'array',
        ];
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(FloodReportPhoto::class);
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'subject')->orderBy('created_at');
    }

    public function evacuationRequests(): HasMany
    {
        return $this->hasMany(EvacuationRequest::class);
    }

    public function logisticsNeeds(): HasMany
    {
        return $this->hasMany(LogisticsNeed::class);
    }

    public function volunteerNeeds(): HasMany
    {
        return $this->hasMany(VolunteerNeed::class);
    }
}
