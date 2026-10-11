<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model {
    public $timestamps = false;
    protected $fillable = [
        'airline_id','flight_number','origin_id','destination_id',
        'departure_time','arrival_time','duration_minutes',
        'price_economy','price_business','seats_economy','seats_business',
        'days_of_week','is_active',
    ];
    protected $casts = [
        'price_economy'  => 'decimal:2',
        'price_business' => 'decimal:2',
    ];
 
    public function airline()     { return $this->belongsTo(Airline::class); }
    public function origin()      { return $this->belongsTo(Airport::class, 'origin_id'); }
    public function destination() { return $this->belongsTo(Airport::class, 'destination_id'); }
    public function bookings()    { return $this->hasMany(FlightBooking::class); }
 
    public function getDurationLabelAttribute(): string {
        $h = intdiv($this->duration_minutes, 60);
        $m = $this->duration_minutes % 60;
        return $m > 0 ? "{$h}j {$m}m" : "{$h}j";
    }
    public function getPriceEconomyLabelAttribute(): string {
        return 'Rp ' . number_format($this->price_economy, 0, ',', '.');
    }
    public function getPriceBusinessLabelAttribute(): string {
        return $this->price_business
            ? 'Rp ' . number_format($this->price_business, 0, ',', '.')
            : 'Tidak tersedia';
    }
}