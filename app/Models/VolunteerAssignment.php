<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerAssignment extends Model
{
    protected $fillable = [
        'assignment_number', 'volunteer_need_id', 'volunteer_id', 'status',
        'assigned_by', 'assigned_at', 'started_at', 'completed_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function need(): BelongsTo
    {
        return $this->belongsTo(VolunteerNeed::class, 'volunteer_need_id');
    }

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
