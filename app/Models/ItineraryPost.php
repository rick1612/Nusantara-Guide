<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryPost extends Model
{
    protected $table = 'itinerary_posts';

    protected $fillable = [
        'user_id', 'title', 'slug', 'cover_image', 'summary', 'body',
        'region_id', 'duration_days', 'estimated_budget', 'actual_budget',
        'travel_style', 'status', 'views', 'is_verified',
        'trip_rating', 'trip_tips',
    ];

    protected $casts = [
        'estimated_budget' => 'decimal:2',
        'actual_budget'    => 'decimal:2',
        'duration_days'    => 'integer',
        'views'            => 'integer',
        'is_verified'      => 'boolean',
        'trip_rating'      => 'integer',
    ];

    // ── RELATIONSHIPS ──────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function days()
    {
        return $this->hasMany(ItineraryDay::class, 'itinerary_id')
                    ->orderBy('day_number');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'itinerary_tags', 'itinerary_id', 'tag_id');
    }

    public function likes()
    {
        return $this->belongsToMany(Customer::class, 'itinerary_likes', 'itinerary_id', 'user_id')
                    ->withPivot('created_at');
    }

    public function comments()
    {
        return $this->hasMany(ItineraryComment::class, 'itinerary_id')->latest();
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(Customer::class, 'saved_itineraries', 'itinerary_id', 'user_id')
                    ->withPivot('saved_at');
    }

    public function copies()
    {
        return $this->hasMany(ItineraryCopy::class, 'original_itinerary_id');
    }

    // ── SCOPES ────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // ── ACCESSORS ─────────────────────────────────────────

    public function getBudgetLabelAttribute(): string
    {
        $b = (int) ($this->actual_budget ?? $this->estimated_budget);
        if (!$b) return 'Tidak disebutkan';
        if ($b >= 1_000_000) return 'Rp ' . number_format($b / 1_000_000, 1) . ' Jt';
        return 'Rp ' . number_format($b / 1_000, 0) . 'K';
    }

    public function getTravelStyleLabelAttribute(): string
    {
        return match($this->travel_style) {
            'backpacker' => '🎒 Backpacker',
            'budget'     => '💰 Budget',
            'mid-range'  => '🏡 Mid-range',
            'luxury'     => '💎 Luxury',
            'family'     => '👨‍👩‍👧 Keluarga',
            'solo'       => '🧍 Solo',
            'couple'     => '👫 Couple',
            'group'      => '👥 Grup',
            default      => $this->travel_style,
        };
    }

    // Auto-marks as verified if any stop links a real booking
    public function checkAndMarkVerified(): void
    {
        $hasRealBooking = $this->days()
            ->with('stops')
            ->get()
            ->flatMap(fn($d) => $d->stops)
            ->filter(fn($s) => $s->flight_booking_id || $s->hotel_booking_id)
            ->isNotEmpty();

        $this->update(['is_verified' => $hasRealBooking]);
    }
}