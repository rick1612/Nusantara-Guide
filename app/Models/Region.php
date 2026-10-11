<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';

    public $timestamps = false;

    protected $fillable = [
        'province_id', 'name', 'slug', 'description',
    ];

    // ── RELATIONSHIPS ──────────────────────────────────────

    // Each region belongs to one province (e.g. Kota Malang → Jawa Timur)
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    // A region has many places (e.g. all places in Kota Malang)
    public function places()
    {
        return $this->hasMany(Place::class);
    }

    // A region can be referenced in many itinerary posts
    public function itineraries()
    {
        return $this->hasMany(ItineraryPost::class);
    }
}
