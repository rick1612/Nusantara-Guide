<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryStop extends Model
{
    protected $table = 'itinerary_stops';
    public $timestamps = false;

    protected $fillable = [
        'day_id', 'stop_type', 'place_id',
        'flight_booking_id', 'hotel_booking_id', 'train_booking_id',
        'custom_place_name', 'custom_title', 'custom_description',
        'visit_order', 'visit_time', 'duration_minutes',
        'tip', 'cost', 'time_start', 'time_end',
        'transport_mode', 'transport_cost', 'order',
    ];

    protected $casts = [
        'cost'           => 'decimal:2',
        'transport_cost' => 'decimal:2',
    ];

    // ── RELATIONSHIPS ─────────────────────────────────────
    public function day()
    {
        return $this->belongsTo(ItineraryDay::class, 'day_id');
    }
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
    public function flightBooking()
    {
        return $this->belongsTo(FlightBooking::class, 'flight_booking_id');
    }
    public function hotelBooking()
    {
        return $this->belongsTo(Booking::class, 'hotel_booking_id');
    }
    public function trainBooking()
    {
        return $this->belongsTo(TrainBooking::class, 'train_booking_id');
    }

    // ── ACCESSORS ─────────────────────────────────────────
    public function getIconAttribute(): string
    {
        return match($this->stop_type) {
            'flight' => '✈️',
            'train'  => '🚆',
            'hotel'  => '🏨',
            'place'  => '📍',
            'food'   => '🍽️',
            'custom' => '📝',
            default  => '📌',
        };
    }

    public function getDisplayNameAttribute(): string
    {
        return match($this->stop_type) {
            'flight' => $this->custom_title ?? 'Penerbangan',
            'train'  => $this->custom_title ?? 'Kereta Api',
            'hotel'  => $this->custom_title ?? optional(optional($this->hotelBooking)->place)->name ?? 'Hotel',
            'place'  => $this->custom_place_name ?? optional($this->place)->name ?? 'Lokasi',
            'food'   => $this->custom_title ?? 'Makan & Minum',
            'custom' => $this->custom_title ?? 'Aktivitas',
            default  => $this->custom_title ?? $this->custom_place_name ?? 'Aktivitas',
        };
    }

    public function getDisplayCostAttribute(): ?float
    {
        if ($this->cost) return (float) $this->cost;
        return match($this->stop_type) {
            'flight' => $this->flightBooking ? (float) $this->flightBooking->total_price : null,
            'train'  => $this->trainBooking  ? (float) $this->trainBooking->total_price  : null,
            'hotel'  => $this->hotelBooking  ? (float) $this->hotelBooking->total_price  : null,
            default  => null,
        };
    }
}