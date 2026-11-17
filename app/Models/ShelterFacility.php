<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShelterFacility extends Model
{
    protected $fillable = ['shelter_id', 'name'];

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }
}
