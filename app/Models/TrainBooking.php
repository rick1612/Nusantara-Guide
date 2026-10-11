<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainBooking extends Model {
    protected $table = 'train_bookings';
    protected $fillable = [
        'user_id','train_id','travel_date','passengers',
        'total_price','passenger_name','passenger_id_number','contact_phone',
        'status','booking_code',
    ];
    protected $casts = ['travel_date' => 'date', 'total_price' => 'decimal:2'];
 
    public function user()  { return $this->belongsTo(Customer::class, 'user_id'); }
    public function train() { return $this->belongsTo(Train::class); }
 
    public static function generateCode(): string {
        $last = self::latest()->first();
        $num  = $last ? ((int) substr($last->booking_code, -5)) + 1 : 1;
        return 'TRN-' . date('Y') . str_pad($num, 4, '0', STR_PAD_LEFT);
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