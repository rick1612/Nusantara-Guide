<?php
// ============================================================
// app/Models/Room.php
// ============================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'place_id', 'name', 'description',
        'price_per_night', 'max_guests', 'image_url', 'is_available',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'is_available'    => 'boolean',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Check if this room is already booked for given dates
    public function isBookedBetween($checkIn, $checkOut): bool
    {
        return $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in',  [$checkIn, $checkOut])
                  ->orWhereBetween('check_out', [$checkIn, $checkOut])
                  ->orWhere(function($q2) use ($checkIn, $checkOut) {
                      $q2->where('check_in',  '<=', $checkIn)
                         ->where('check_out', '>=', $checkOut);
                  });
            })->exists();
    }

    // Formatted price
    public function getPriceLabelAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_night, 0, ',', '.');
    }
}
