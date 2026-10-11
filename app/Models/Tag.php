<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    public $timestamps = false;

    protected $fillable = [
        'name', 'slug',
    ];

    // ── RELATIONSHIPS ──────────────────────────────────────

    // A tag can belong to many itinerary posts
    public function itineraries()
    {
        return $this->belongsToMany(
            ItineraryPost::class, 'itinerary_tags', 'tag_id', 'itinerary_id'
        );
    }
}
