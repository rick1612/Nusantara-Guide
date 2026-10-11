<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryCopy extends Model
{
    protected $table = 'itinerary_copies';
    public $timestamps = false;

    protected $fillable = ['original_itinerary_id', 'user_id', 'copied_at'];

    protected $casts = ['copied_at' => 'datetime'];

    public function originalItinerary()
    {
        return $this->belongsTo(ItineraryPost::class, 'original_itinerary_id');
    }

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
}