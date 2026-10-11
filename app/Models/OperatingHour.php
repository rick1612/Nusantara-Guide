<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatingHour extends Model
{
    protected $table = 'operating_hours';

    public $timestamps = false;

    protected $fillable = [
        'place_id', 'day_of_week', 'open_time', 'close_time', 'is_closed',
    ];

    // Each operating hour record belongs to one place
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    // ── ACCESSORS ─────────────────────────────────────────

    // Returns "08:00 - 17:00" or "Tutup" nicely formatted for display
    public function getHoursLabelAttribute(): string
    {
        if ($this->is_closed) return 'Tutup';
        $open  = substr($this->open_time,  0, 5);
        $close = substr($this->close_time, 0, 5);
        return "$open – $close";
    }
}