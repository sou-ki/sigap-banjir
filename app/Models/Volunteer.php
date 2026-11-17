<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volunteer extends Model
{
    protected $fillable = ['user_id', 'name', 'phone', 'domicile', 'status', 'notes'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(VolunteerSkill::class, 'skill_volunteer');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(VolunteerAssignment::class);
    }
}
