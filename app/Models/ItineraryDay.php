<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryDay extends Model
{
    protected $table = 'itinerary_days';

    public $timestamps = false;

    protected $fillable = [
        'itinerary_id', 'day_number', 'title', 'notes',
    ];

    // ── RELATIONSHIPS ──────────────────────────────────────

    // Each day belongs to one itinerary post
    public function itinerary()
    {
        return $this->belongsTo(ItineraryPost::class, 'itinerary_id');
    }

    // Each day has many stops (places visited that day), ordered by visit_order
    public function stops()
    {
        return $this->hasMany(ItineraryStop::class, 'day_id')
                    ->orderBy('visit_order');
    }
}
