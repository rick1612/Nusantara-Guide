<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $fillable = [
        'name','train_number','class',
        'origin_id','destination_id',
        'departure_time','arrival_time',
        'duration_minutes','price','seats',
        'days_of_week','is_active',
    ];

    protected $casts = ['price' => 'decimal:2'];

    public function getPriceLabelAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getDurationLabelAttribute(): string
    {
        $h = intdiv($this->duration_minutes, 60);
        $m = $this->duration_minutes % 60;
        return $m > 0 ? "{$h}j {$m}m" : "{$h}j";
    }

    public function originStation()
    {
        return $this->belongsTo(TrainStation::class, 'origin_id');
    }

    public function destinationStation()
    {
        return $this->belongsTo(TrainStation::class, 'destination_id');
    }

    // Aliases matching TransportationModels.php
    public function origin()
    {
        return $this->belongsTo(TrainStation::class, 'origin_id');
    }

    public function destination()
    {
        return $this->belongsTo(TrainStation::class, 'destination_id');
    }

    public function bookings()
    {
        return $this->hasMany(TrainBooking::class);
    }
}