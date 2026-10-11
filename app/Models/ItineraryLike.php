<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryLike extends Model
{
    protected $table = 'itinerary_likes';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['itinerary_id', 'user_id'];

    public function itinerary()
    {
        return $this->belongsTo(ItineraryPost::class, 'itinerary_id');
    }

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
}