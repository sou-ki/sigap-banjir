<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VolunteerSkill extends Model
{
    protected $fillable = ['name'];

    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class, 'skill_volunteer');
    }
}
