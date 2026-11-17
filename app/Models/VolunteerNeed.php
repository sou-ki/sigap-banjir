<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VolunteerNeed extends Model
{
    protected $fillable = [
        'need_number', 'title', 'description', 'location', 'flood_report_id',
        'shelter_id', 'volunteers_required', 'volunteers_assigned',
        'required_skills', 'priority', 'status', 'created_by',
    ];

    protected function casts(): array
    {
        return ['required_skills' => 'array'];
    }

    public function floodReport(): BelongsTo
    {
        return $this->belongsTo(FloodReport::class);
    }

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(VolunteerAssignment::class);
    }
}
