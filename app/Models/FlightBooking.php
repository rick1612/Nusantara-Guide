<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightBooking extends Model {
    protected $table = 'flight_bookings';
    protected $fillable = [
        'user_id','flight_id','travel_date','seat_class','passengers',
        'total_price','passenger_name','passenger_id_number','contact_phone',
        'status','booking_code',
    ];
    protected $casts = ['travel_date' => 'date', 'total_price' => 'decimal:2'];
 
    public function user()   { return $this->belongsTo(Customer::class, 'user_id'); }
    public function flight() { return $this->belongsTo(Flight::class); }
 
    public static function generateCode(): string {
        $last = self::latest()->first();
        $num  = $last ? ((int) substr($last->booking_code, -5)) + 1 : 1;
        return 'FLT-' . date('Y') . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
    public function getTotalLabelAttribute(): string {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
    public function getStatusColorAttribute(): string {
        return match($this->status) {
            'confirmed' => '#2d6a4f', 'cancelled' => '#e76f51', default => '#e9c46a',
        };
    }
    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'confirmed' => '✓ Dikonfirmasi', 'cancelled' => '✗ Dibatalkan', default => '⏳ Menunggu',
        };
    }
}