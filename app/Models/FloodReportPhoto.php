<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FloodReportPhoto extends Model
{
    protected $fillable = ['flood_report_id', 'path', 'media_type', 'original_name', 'size_bytes'];

    public function floodReport(): BelongsTo
    {
        return $this->belongsTo(FloodReport::class);
    }
}
