<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryComment extends Model
{
    protected $table = 'itinerary_comments';

    // Only created_at, no updated_at (comments can't be edited)
    public $timestamps = false;

    protected $fillable = [
        'itinerary_id', 'user_id', 'comment',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ── RELATIONSHIPS ──────────────────────────────────────

    // Each comment belongs to one itinerary post
    public function itinerary()
    {
        return $this->belongsTo(ItineraryPost::class, 'itinerary_id');
    }

    // Each comment was written by one user
    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
}
